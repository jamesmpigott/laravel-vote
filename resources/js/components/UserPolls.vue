<template>
    <div class="">
        <span class="block text-xl font-serif mt-6 mb-4 ">Your polls</span>
        <div class="flex flex-col divide-y divide-gray-500">
            <div v-for="poll in polls" v-bind:key="poll.slug" class="flex justify-between items-center py-2">
                <span class="block w-10/12">{{ poll.title }}</span>
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
</template>

<script>
    export default {
        data: function() {
            return {
                polls: null,
                data: {},
            }
        },
        methods: {
            loadPolls: function() {
                axios.get('/api/get-user-polls/' )
                    .then((response) => {
                        this.polls = response.data.data;
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
                this.loadPolls();
            });
        }
    }
</script>
