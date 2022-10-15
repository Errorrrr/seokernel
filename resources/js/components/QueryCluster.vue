<template>
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Таблица запросов</p>
                    <div class="table-responsive">
                        <table id="recent-purchases-listing" class="table">
                            <thead>
                            <tr>
                                <th>Запрос</th>
                                <th>Дата</th>
                                <th>Статус</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(query,index) in queries">
                                <td>{{query.query}}</td>
                                <td>{{ query.date }}</td>
                                <td v-if="query.status == 1">Готово</td>
                                <td v-if="query.status == 0">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: 90%"  :style="{ width: (query.countNowQueries*100/query.countQueries) + '%' }"
                                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <span v-if="query.countQueries != 0">{{query.countNowQueries}} / {{query.countQueries}}
                                        запросов обработано</span>
                                </td>
                                <td>
                                    <button v-if="query.status == 1" type="button" class="btn btn-success btn-md" v-on:click="downloadExcel(query.query)">Excel</button>
                                    <button type="button" class="btn btn-danger btn-md" v-on:click="deleteQuery(query.query,index)">x</button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                queries: [],
            }
        },
        mounted() {

            axios
                .get('/api/get_query_cluster')
                .then((response) => {
                    let list = []
                    response.data.map(function(value, key) {
                        list.push(value);
                    });
                    this.queries = list;
                });

            //Чтобы человеку не обновлять страницу
            setInterval(()=> {
                    let needReq = false

                    this.queries.map((value, key) =>{
                        if(value.status == 0){
                            needReq = true
                        }
                    });

                    if(needReq){
                        axios
                            .get('/api/get_query_cluster')
                            .then((response) => {
                                let list = []
                                response.data.map(function(value, key) {
                                    list.push(value);
                                });
                                this.queries = list;
                            });
                    }
                }, 1000);

        },
        methods: {
            downloadExcel: function(query) {
                window.location.replace("/api/download_excel_cluster/"+encodeURI(query));
            },
            deleteQuery: function(query, index) {
                axios
                    .post('/api/delete_query_cluster', {query:query})
                    .then((response) => {
                        this.queries.splice(index, 1);
                    });
            }
        }
    }
</script>
