<template>
    <form action="#" @submit.prevent="submit()">
        
        <div v-if="success" class="flex flex-col items-center justify-center text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="block text-lg font-semibold text-slate-900">Thanks for your vote!</span>
        </div>
        <div v-else class="text-left">
            <h1 class="text-xl font-semibold mb-8">
                {{ poll.title }}
            </h1>
            <input type="hidden" id="poll_slug" name="poll_slug" :value="poll.slug">
            <div class="mb-8">
                <div class="form-check my-2.5" v-for="option in poll.options">
                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                        type="radio"
                        name="option"
                        v-model="fields.option_id"
                        v-bind:id="'option_' + option.slug"
                        v-bind:value="option.slug">
                    <label class="form-check-label inline-block text-gray-800 hover:cursor-pointer"
                        v-bind:for="'option_' + option.slug">
                        {{ option.value }}
                    </label>
                </div>
                <div v-if="errors && errors.option_id" class="text-sm text-red-500">
                    {{ errors.option_id[0] }}
                </div>
            </div>

            <div class="flex items-start flex-col">
                <label for="email" class="text-sm text-gray-600">Email Address</label>
                <input v-model="fields.email" type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <div v-if="errors && errors.email" class="text-sm text-red-500">
                    {{ errors.email[0] }}
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" 
                    class="w-full items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Submit
                </button>
            </div>

        </div>
    </form>    
</template>

<script>
    export default {
        props: [
            'slug'
        ],
        data: function() {
            return {
                poll: null,
                fields: {},
                success: false,
                errors: {}
            }
        },
        mounted() {
            this.loadPoll();
        },
        methods: {
            loadPoll: function() {
                axios.get('/api/polls/' + this.$props.slug)
                .then((response) => {
                    this.poll = response.data.data;
                    console.log(this.poll);
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            submit: function() {
                this.fields.poll_slug = document.getElementById('poll_slug').value;
                axios.post('/api/vote', this.fields)
                    .then((response) => {
                        this.fields = {};
                        this.success = true;
                        this.errors = {};
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
