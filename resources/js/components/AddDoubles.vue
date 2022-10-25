<template>
    <div>

        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Список запросов</p>
                        <div class="form-group" >
                            <label for="exampleTextarea1">Введите до 10 тысяч запросов. Каждый новый запрос с новой строки</label>
                            <textarea class="form-control" id="exampleTextarea1" rows="20" v-model="userQueries"></textarea>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col"></div>
                            <div class="col-12 col-sm-auto">
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
                userQueries: '',
                errorBalance: '',
            }
        },
        mounted() {

        },
        methods: {
            addTask: function() {
                this.errorBalance = '';
                    axios
                    .post('/api/add_doubles', {userQueries: this.userQueries})
                    .then((response) => {

                        if(response.data == 'ok'){
                            window.location.replace("/doubles");
                        }else{
                            this.errorBalance = "Недостаточно средств.";
                        }
                    });
            }

        }
    }
</script>
