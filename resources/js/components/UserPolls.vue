<template>
    <div class="">
        <span class="block text-xl font-serif mt-6 mb-4 ">Your polls</span>
        <div class="flex flex-col divide-y divide-gray-500">
            <div v-for="poll in polls" v-bind:key="poll.slug" class="flex justify-between items-center py-2">
                <span class="block w-10/12">{{ poll.title }}</span>
                <a :href="poll.url" target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                polls: null,
            }
        },
        methods: {
            loadPolls: function() {
                axios.get('/api/get-user-polls/' )
                    .then((response) => {
                        this.polls = response.data.data;
                        console.log(this.polls);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        mounted() {
            this.loadPolls();
        }
    }
</script>
