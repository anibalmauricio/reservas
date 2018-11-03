<template>
    <li class="divider" role="presentation">{{bookings.col}} {{ bookings.row }}</li>
</template>
<script>
    export default {
        props: ['bookings'],
        data() {
            return {
            }
        },
        mounted() {
            console.log('Component BookingsComponent.vue mounted.');
            console.log(this.bookings);
        },
        methods: {
            
        }
    }
</script>
