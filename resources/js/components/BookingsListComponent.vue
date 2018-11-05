<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="/reservas/new" class="btn btn-primary float-right mb-3">Nueva Reserva</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo Reserva</th>
                        <th scope="col">Fecha Reserva</th>
                        <th scope="col"># Personas</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(n_book, index) in bookings">
                        <tr>
                            <th>
                                {{index + 1}}
                            </th>
                            <td>
                                {{n_book.codigo_reserva}}
                            </td>
                            <td>
                                {{n_book.fecha_reserva}}
                            </td>
                            <td>
                                {{n_book.personas}}
                            </td>
                            <td>
                                <a class="btn-view-fund btn btn-default btn-xs float-right" v-bind:href="'/reservas/' + n_book.id"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn-view-fund btn btn-default btn-xs float-right" v-on:click="onClickDelete(index, n_book.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                bookings: []
            }
        },
        mounted() {
            console.log('Component mounted BookingsListComponent.vue.');
            axios.get('/reserva').then((response) => {
                console.log('response', response);
                this.bookings = response.data;
            })
            
            // axios.get('/thoughts').then((response) => {
            //     this.thoughts = response.data;
            // })
        },
        methods: {
            onClickDelete(index, book_id) {
                if (confirm('Está seguro de querer eliminar esta reserva? ')) {
                    axios.delete(`/reserva/${book_id}`).then((response) => {
                        // this.bookings = response.data;
                        console.log(response);
                        // this.$emit('delete');
                        this.bookings.splice(index, 1);
                    });
                }
            }
        }
    }
</script>
