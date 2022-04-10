<template>
     <form action="#" @submit.prevent="submit()">
        
        <div v-if="success" class="flex flex-col items-center justify-center text-green-500 my-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="block text-xl mt-4 font-semibold text-slate-900">Your Poll has been created!</span>

            <div class="w-full lg:w-3/4 relative mt-8">
                <input 
                    class="w-full rounded border-gray-300 text-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50"
                    :value="pollData.url"
                    v-on:focus="$event.target.select()"
                    ref="clone"
                    type="text"
                    readonly
                >
                <button @click="copy" class="absolute right-2 top-[calc(50%-0.625rem)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-400 h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                    </svg>
                </button>
            </div>
        </div>
        <div v-else class="text-left flex flex-col gap-y-4">
            <div class="flex items-start flex-col gap-y-2">
                <label for="email" class="block font-medium text-sm text-gray-700">What's your question?</label>
                <input v-model="fields.title" type="text" name="title" id="title" class="w-full rounded border-gray-300 text-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                <div v-if="errors && errors.title" class="text-xs text-red-600">
                    {{ errors.title[0] }}
                </div>
            </div>

            <div class="flex items-start flex-col gap-y-2">
                <label for="options" class="block font-medium text-sm text-gray-700">What are the choices?</label>
                
                <div v-for="(option, index) in options" class="w-full">
                    <div class="flex justify-between items-center">
                        <input 
                            v-model="option.value"
                            type="text"
                            name="value"
                            :data-index="index"
                            class="w-11/12 rounded border-gray-300 text-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50"
                        >

                        <input 
                            v-model="option.color"
                            type="color"
                            id="head"
                            name="head"
                            class="ml-2 rounded-lg"
                        >

                        <button type="button" :disabled="index <= 1 ? true : false" @click="removeField" class="mr-0 ml-2 block text-white disabled:opacity-40 bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-base p-2.5 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                            </svg>
                        </button>
                    </div>

                    <div v-if="errors && errors['options.' + index +'.value']" class="w-full text-xs text-red-600">
                        {{ errors['options.' + index +'.value'][0] }}
                    </div>
                </div>
                
                <button @click="addField" type="button" class="mt-3 mr-0 ml-auto block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base p-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="flex divide-x divide-slate-300">
                <div class="flex flex-col justify-center items-center w-1/2 gap-y-3 py-8 px-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                    <span class="text-lg font-normal">Anonymous Voting</span>
                    <label for="anon_voting" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input 
                                type="checkbox"
                                class="sr-only peer"
                                name="anon_voting"
                                id="anon_voting"
                                v-model="fields.anon_voting"
                            >
                                <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                                <div class="dot absolute w-6 h-6 bg-gray-300 rounded-full shadow -left-1 -top-1 transition peer-checked:translate-x-full peer-checked:bg-blue-700"></div>
                            </div>
                    </label>
                </div>

                <div class="flex flex-col justify-center items-center w-1/2 gap-y-3 py-8 px-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-lg font-normal">Vote Geolocation Tracking</span>
                    <label for="geolocation_tracking" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input 
                                type="checkbox"
                                class="sr-only peer"
                                name="geolocation_tracking"
                                id="geolocation_tracking"
                                v-model="fields.geolocation_tracking"
                                checked="checked"
                            >
                                <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                                <div class="dot absolute w-6 h-6 bg-gray-300 rounded-full shadow -left-1 -top-1 transition peer-checked:translate-x-full peer-checked:bg-blue-700"></div>
                            </div>
                    </label>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Create your poll
                </button>
            </div>

        </div>
    </form> 
</template>

<script>
    import VueRandomColor from 'vue-randomcolor';
    Vue.use(VueRandomColor);

    export default {
        data: function() {
            return {
                options: [
                    {
                        value: '',
                        color: this.$randomColor()
                    },
                    {
                        value: '',
                        color: this.$randomColor()
                    }
                ],
                fields: {
                    anon_voting: false,
                    geolocation_tracking: true
                },
                success: false,
                errors: {},
                pollData: false
            }
        },
        methods: {
            addField: function() {
                this.options.push({
                    value: '',
                    color: this.$randomColor()
                });
            },
            removeField: function(event) {
                let index = event.target.previousElementSibling.getAttribute('data-index');
                this.options.splice(index, 1);
            },
            copy: function() {
                this.$refs.clone.focus();
                document.execCommand('copy');
            },
            submit: function() {
                this.fields.options = this.options;
                console.log(this.fields);

                axios.post('/api/create/poll', this.fields)
                    .then((response) => {
                        this.fields = {};
                        this.success = true;
                        this.errors = {};
                        this.pollData = response.data.data;

                        this.$root.$emit('poll-builder-update');
                    })
                    .catch((error) => {
                        if(error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
            }
        }
    }
</script>
