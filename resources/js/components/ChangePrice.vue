<template>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Настройка цен</h4>
                <div class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputName1">Цена "Запросы конкурентов"</label>
                        <input type="text" class="form-control" id="exampleInputName1" v-model="price_conc">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Цена "Кластеризатор"</label>
                        <input class="form-control" id="exampleInputEmail3" v-model="price_cluster">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" v-on:click="submit">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                price_cluster: 0,
                price_conc: 0,
            }
        },
        mounted() {
            axios
                .get('/api/get_price')
                .then((response) => {
                    this.price_cluster = response.data.cluster_price;
                    this.price_conc = response.data.conc_price;
                });
        },
        methods: {
            submit: function() {
                axios
                    .post('/api/change_price', {cluster_price:this.price_cluster, conc_price: this.price_conc})
                    .then((response) => {

                    });
            },


        }
    }
</script>
