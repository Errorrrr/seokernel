<template>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Настройка стоп слов</h4>
                <div class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputName1">Стоп лист частичный "Кластеризатор"</label>
                        <textarea class="form-control" id="exampleTextarea1" rows="15" v-model="partCluster"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Стоп лист полный "Кластеризатор" </label>
                        <textarea class="form-control" id="exampleTextarea2" rows="15" v-model="fullCluster"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Стоп лист для keys.so</label>
                        <textarea class="form-control" id="exampleTextarea3" rows="15" v-model="stopKeys"></textarea>
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
                stopKeys: '',
                fullCluster: '',
                partCluster: '',
            }
        },
        mounted() {
            axios
                .get('/api/get_stops')
                .then((response) => {
                    this.stopKeys = response.data.stopKeys;
                    this.fullCluster = response.data.fullCluster;
                    this.partCluster = response.data.partCluster;
                });
        },
        methods: {
            submit: function() {
                axios
                    .post('/api/change_stops', {stopKeys:this.stopKeys,
                        fullCluster: this.fullCluster, partCluster: this.partCluster})
                    .then((response) => {

                    });
            },


        }
    }
</script>
