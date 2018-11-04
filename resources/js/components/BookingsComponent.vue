<template>
    <li class="divider list-group-item list-group-item-action" role="presentation" title="Borrar Reserva">{{bookings.col}} {{ bookings.row }}
        <button class="btn-view-fund btn btn-default btn-xs float-right" type="button" v-on:click="onClickDeleteBook(bookings.index_row, bookings.index_col)">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </button>
    </li>
</template>
<script>
    export default {
        props: ['bookings'],
        data() {
            return {
            }
        },
        mounted() {
            // console.log('Component BookingsComponent.vue mounted.');
            console.log('bookings ',this.bookings);
        },
        methods: {
            onClickDeleteBook: function(row, col) {
                // alert('aaaaa');
                this.$emit('delete');
                this.$root.$emit('createImage', row, col)
            }
        }
    }
</script>
