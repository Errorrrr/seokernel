<template>
    <div>
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="form-inline" >
                        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" v-model="queryString"
                               placeholder="Основной коммерческий запрос страницы" style="width:500px;">

                        <div class="input-group mb-2 mr-sm-2">
                            <select class="form-control form-control-lg" id="exampleFormControlSelect1" v-model="limit">
                                <option>ТОП-10</option>
                                <option>ТОП-20</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2"
                                v-on:click="submit" :disabled="loading != ''">Получить конкурентов</button>
                        <br>

                    </div>
                    <span style="color:red;font-size: 0.85rem;" >{{this.errorString}}</span>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Таблица конкурентов</p>
                        <div class="table-responsive">
                            <table id="recent-purchases-listing" class="table">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Страница</th>
                                    <th>Взять</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(query,index) in queries">
                                    <td>{{index+1}}</td>
                                    <td v-bind:style= "query.hide == 1 ? 'color:lightgray' : ''"><a v-bind:style= "query.hide == 1 ? 'color:lightgray' : ''" :href="query.name" target="_blank">{{ query.name }}</a></td>
                                    <td>
                                        <label v-if="query.hide == 0" class="badge badge-secondary" v-on:click="hideRow(index)">Убрать</label>
                                        <label v-if="query.hide == 1" class="badge badge-danger" v-on:click="hideRow(index)">Вернуть</label>
                                    </td>
                                </tr>


                                </tbody>
                            </table>
                            <div style="text-align: center;"><h3>{{loading}}</h3></div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="col"></div>
                            <div class="col-12 col-sm-auto">
                                <a href="/queries"><button type="submit" class="btn btn-secondary mr-2" >Отменить</button></a>
                                <button type="submit" class="btn btn-primary mr-2" v-on:click="addTask">Запустить</button>
                                <span>{{errorBalance}}</span>
                            </div>
                        </div>
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
                queryString: '',
                queries: [],
                limit: 'ТОП-10',
                errorString: '',
                loading: '',
                errorBalance: '',
            }
        },
        mounted() {

        },
        methods: {
            submit: function() {
                this.loading = 'Загрузка...';
                this.errorString = ''
                if(this.queryString == ''){
                    this.errorString += 'Введите поисковый запрос. ';
                }
                if(this.errorString != ''){
                    return;
                }
                axios
                    .post('/api/pages_list', {request:this.queryString, limit: this.limit})
                    .then((response) => {

                        this.loading = '';
                        if(response.data == 'err'){
                            this.errorString += 'Вы ввели запрещённый запрос';
                        }else{
                            let list = []
                            response.data.map(function(value, key) {
                                list.push({name:value,hide:0});
                            });
                            this.queries = list;
                        }
                    });
            },
            addTask: function() {
                let siteList = []
                this.queries.map(function(value, key) {
                    if(value.hide == 0){
                        siteList.push(value.name);
                    }
                });
                axios
                    .post('/api/add_task', {list:siteList, query: this.queryString})
                    .then((response) => {
                        if(response.data == 'ok'){
                            window.location.replace("/queries");
                        }else{
                            this.errorBalance = "Недостаточно средств.";
                        }
                    });
            },
            hideRow: function(index){
                this.queries[index].hide = (this.queries[index].hide == 1 ? 0 : 1);
            },


        }
    }
</script>
