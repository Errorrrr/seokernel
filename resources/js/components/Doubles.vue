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
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(query,index) in queries">
                                <td>{{query.name}}</td>
                                <td>{{ query.date }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-md" v-on:click="downloadExcel(query.name)">Excel</button>
                                    <button type="button" class="btn btn-danger btn-md" v-on:click="deleteQuery(query.name,index)">x</button>
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
                .get('/api/get_doubles')
                .then((response) => {
                    let list = []
                    response.data.map(function(value, key) {
                        list.push(value);
                    });
                    this.queries = list;
                });
        },
        methods: {
            downloadExcel: function(query) {
                window.location.replace("/api/download_excel_doubles/"+encodeURI(query));
            },
            deleteQuery: function(query, index) {
                axios
                    .post('/api/delete_doubles', {name:query})
                    .then((response) => {
                        this.queries.splice(index, 1);
                    });
            }
        }
    }
</script>
