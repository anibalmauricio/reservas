<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- <div class="card mb-3"> -->
                <!-- <div class="card-body"> -->
                    <grid-component 
                        @updateNewBooking="addThought"
                        :new_bookings="new_bookings"
                        :cols="cols"
                        :rows="rows"></grid-component>
                <!-- </div> -->
            <!-- </div> -->

            <div v-if="bookings.length > 0" class="card mb-3">
                <div class="card-body">
                    <ul>
                    <bookings-component 
                        v-for="(n_book, index) in bookings" 
                        :key="index" 
                        :bookings="n_book"
                        ></bookings-component>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                cols: this.cols_range('A', 'J'),
                rows: this.rows_range(1, 5),
                new_bookings: [],
                bookings: [],
                col: '',
                row: ''
            }
        },
        mounted() {
            console.log('Component mounted.');
            // axios.get('/thoughts').then((response) => {
            //     this.thoughts = response.data;
            // })
        },
        methods: {
            addThought(index_row, index_col) {
                console.log('addThought', index_row, index_col);
                this.bookings.push({
                    'col': this.cols[index_col],
                    'row': this.rows[index_row]
                });

                console.log(this.bookings);
            },
            deleteThought(index) {
                this.thoughts.splice(index, 1);
            },
            updateThought(index, thought) {
                this.thoughts[index] = thought;
            },
            cols_range: function(start,stop) {
                var result=[];
                for (var idx=start.charCodeAt(0), end=stop.charCodeAt(0); idx <= end; ++idx){
                    result.push(String.fromCharCode(idx));
                }
                return result;
            },
            rows_range: function(start, end) {
                return Array(end - start + 1).fill().map((_, idx) => start + idx)
            }
        }
    }
</script>
