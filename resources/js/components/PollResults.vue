<template>
    <div>
        test
    </div>
</template>
<script>
    export default {
        props: [
            'props'
        ],
        mounted() {
            console.log('mount me baby');
            console.log(this.$props.props.pollSlug);
        }
    }
</script>