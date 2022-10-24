<template>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Настройка констант</h4>
                <div class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputName1">Цена "Запросы конкурентов"</label>
                        <input type="text" class="form-control" id="exampleInputName1" v-model="price_conc">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Цена "Кластеризатор"</label>
                        <input class="form-control" id="exampleInputEmail3" v-model="price_cluster">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail4">Стартовый баланс юзера</label>
                        <input class="form-control" id="exampleInputEmail4" v-model="start_balance">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail5">Ключ API keyso</label>
                        <input class="form-control" id="exampleInputEmail5" v-model="api_keyso">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail6">Ключ API xmlstock</label>
                        <input class="form-control" id="exampleInputEmail6" v-model="api_stack">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail7">Ключ API xmlproxy</label>
                        <input class="form-control" id="exampleInputEmail7" v-model="api_proxy">
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
                start_balance: 0,
                api_stack: 0,
                api_proxy: 0,
                api_keyso: 0,
            }
        },
        mounted() {
            axios
                .get('/api/get_price')
                .then((response) => {
                    this.price_cluster = response.data.cluster_price;
                    this.price_conc = response.data.conc_price;
                    this.start_balance = response.data.start_balance;
                    this.api_stack = response.data.api_stack;
                    this.api_proxy = response.data.api_proxy;
                    this.api_keyso = response.data.api_keyso;
                });
        },
        methods: {
            submit: function() {
                axios
                    .post('/api/change_price', {cluster_price:this.price_cluster,
                        conc_price: this.price_conc, start_balance: this.start_balance,
                        api_stack: this.api_stack, api_proxy: this.api_proxy, api_keyso: this.api_keyso,
                    })
                    .then((response) => {

                    });
            },


        }
    }
</script>
