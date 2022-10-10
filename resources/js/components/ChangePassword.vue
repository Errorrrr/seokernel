<template>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Сменить пароль</h4>
                <div class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputName1">Введите старый пароль</label>
                        <input type="password" class="form-control" id="exampleInputName1" v-model="old_pass">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Введите новый пароль</label>
                        <input type="password" class="form-control" id="exampleInputEmail3" v-model="new_pass">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Повторите новый пароль</label>
                        <input type="password" class="form-control" id="exampleInputEmail3" v-model="new_pass_accept">
                    </div>
                    <p>{{errorString}}</p>
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
                old_pass: '',
                new_pass: '',
                new_pass_accept: '',
                errorString: '',
            }
        },
        mounted() {

        },
        methods: {
            submit: function() {
                this.errorString = '';
                axios
                    .post('/api/change_password', {old_pass:this.old_pass, new_pass: this.new_pass, new_pass_accept: this.new_pass_accept})
                    .then((response) => {
                        if(response.data != 'ok'){
                            this.errorString = response.data;
                        }else{
                            this.old_pass='';
                            this.new_pass= '';
                            this.new_pass_accept='';
                        }
                    });
            },


        }
    }
</script>
