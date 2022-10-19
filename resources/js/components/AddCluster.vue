<template>
    <div>

        <div class="col-12 grid-margin" v-if="stage==1">
            <div class="card">
                <div class="card-body">
                    <div class="form-inline" >
                        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" v-model="queryString"
                               placeholder="Основной коммерческий запрос страницы" style="width:500px;">
                        <autocomplete
                            url="/api/get_regions"
                            anchor="name"
                            label=""
                            :classes="{input: 'form-control mb-2 mr-sm-2'}"
                            :on-select="getData"
                            placeholder="Введите регион"
                        >
                        </autocomplete>
                        <button type="submit" class="btn btn-primary mb-2"
                                v-on:click="submit" :disabled="loading != ''">Получить конкурентов</button>
                    </div>
                    <span style="color:red;font-size: 0.85rem;" >{{this.errorString}}</span>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title" v-if="stage==1">Таблица сайтов</p>
                        <p class="card-title" v-if="stage==2">Список ваших запросов</p>
                        <div class="table-responsive" v-if="stage==1">
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
                                    <td v-bind:style= "query.hide == 1 ? 'color:lightgray' : ''">{{ query.name }}</td>
                                    <td>
                                        <label v-if="query.hide == 0" class="badge badge-secondary" v-on:click="hideRow(index)">Убрать</label>
                                        <label v-if="query.hide == 1" class="badge badge-danger" v-on:click="hideRow(index)">Вернуть</label>
                                    </td>
                                </tr>


                                </tbody>
                            </table>

                        </div>
                        <div class="form-group" v-if="stage==2">
                            <label for="exampleTextarea1">Введите до 10 тысяч запросов. Каждый новый запрос с новой строки</label>
                            <textarea class="form-control" id="exampleTextarea1" rows="20" v-model="userQueries"></textarea>
                        </div>
                        <br>
                        <div style="text-align: center;"><h3>{{loading}}</h3></div>

                        <div class="row">

                            <div class="col"></div>
                            <div class="col-12 col-sm-auto">
                                <a v-if="stage==1" href="/queries"><button type="submit" class="btn btn-secondary mr-2" >Отменить</button></a>
                                <button v-if="stage==2" type="submit" class="btn btn-secondary mr-2" v-on:click="changeStage(1)">Назад</button>
                                <button v-if="stage==1 && queries.length > 0" type="submit" class="btn btn-primary mr-2" v-on:click="changeStage(2)">Дальше</button>
                                <button v-if="stage==2" type="submit" class="btn btn-primary mr-2" v-on:click="addTask">Запустить</button>
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
    import Autocomplete from 'vue2-autocomplete-js'

    export default {
        components: {
            Autocomplete
        },
        data() {
            return {
                queryString: '',
                queries: [],
                limit: 'ТОП-20',
                region: '',
                stage: 1,
                errorString: '',
                userQueries: '',
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
                if(this.region == ''){
                    this.errorString += ' Введите регион.';
                }
                if(this.errorString != ''){
                    return;
                }
                axios
                    .post('/api/pages_list', {request:this.queryString, limit: this.limit, region: this.region})
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
                    .post('/api/cluster_add_task', {sites: this.queries,list: siteList, query: this.queryString, region: this.region, userQueries: this.userQueries})
                    .then((response) => {

                        if(response.data == 'ok'){
                            window.location.replace("/clusters");
                        }else{
                            this.errorBalance = "Недостаточно средств.";
                        }
                    });
            },
            hideRow: function(index){
                this.queries[index].hide = (this.queries[index].hide == 1 ? 0 : 1);
            },
            getData(obj){
                this.region = obj.code;
            },
            changeStage(stage){
                this.stage = stage;
            }

        }
    }
</script>
