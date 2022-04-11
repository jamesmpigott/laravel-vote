<template>
    <form action="#" @submit.prevent="submit()" v-if="pollFetched">
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

            <div v-if="!poll.anon_voting" class="flex items-start flex-col">
                <label for="email" class="text-sm text-gray-600">Email Address</label>
                <input v-model="fields.email" type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <div v-if="errors && errors.email" class="text-sm text-red-500">
                    {{ errors.email[0] }}
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" 
                    class="w-full items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>

        </div>
    </form>
    <div v-else class="w-full flex justify-center py-8">
        <svg role="status" class="w-12 h-12 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
        </svg>
    </div>
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
                errors: {},
                pollFetched: false
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
                    this.pollFetched = true;
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
