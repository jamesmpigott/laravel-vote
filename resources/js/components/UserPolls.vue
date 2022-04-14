<template>
    <div v-if="dataFetched">
        <div v-if="!polls.length" class="mt-6">
            {{ this.$trans.get('generic.no-polls') }}
        </div>
        <div v-else class="mt-6">
            <span class="block text-xl font-serif mb-2">{{ this.$trans.get('generic.your-polls') }}</span>
            <div class="flex flex-col divide-y divide-gray-500">
                <div v-for="poll in polls" v-bind:key="poll.slug" class="flex justify-between items-center py-1.5">
                    <span class="block w-10/12 pr-4">{{ poll.title }}</span>
                    <div class="flex gap-1.5">
                        <button v-on:click="openModal(poll.title); switchModalComponent(poll.slug)"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                        </button>

                        <a :href="poll.url" target="_blank"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="w-full flex justify-center py-8">
        <svg role="status" class="w-12 h-12 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
        </svg>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                polls: null,
                data: {},
                dataFetched: false
            }
        },
        methods: {
            loadPolls: function() {
                axios.get('/api/get-user-polls/' )
                    .then((response) => {
                        this.polls = response.data.data;
                        this.dataFetched = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            openModal: function(title) {
                this.$root.$emit('open-modal');
                this.$root.$emit('set-modal-data', this.data, title);
            },
            switchModalComponent: function(slug) {
                this.$root.currentModalComponent = 'pollResults';
                this.$root.subdata = {
                    pollSlug: slug
                };
            }
        },
        mounted() {
            this.loadPolls();

            this.$root.$on('poll-builder-update', () => {
                this.dataFetched = false;
                this.loadPolls();
            });
        }
    }
</script>
