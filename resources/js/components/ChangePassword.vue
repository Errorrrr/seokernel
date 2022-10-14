<template>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Сменить пароль</h4>
                <div class="forms-sample">
                    Новый пароль вышлет наш телеграм бот.
                    <p>{{errorString}}</p>
                    <p style="color: green;">{{success}}</p>
                    <button type="submit" class="btn btn-primary mr-2" v-on:click="submit">Сменить пароль</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errorString: '',
                success: '',
            }
        },
        mounted() {

        },
        methods: {
            submit: function() {
                this.errorString = '';
                this.success = '';
                axios
                    .post('/api/change_password', {})
                    .then((response) => {
                        if(response.data != 'ok'){
                            this.errorString = response.data;
                        }else{
                            this.success = 'Пароль успешно обновлен';

                        }
                    });
            },


        }
    }
</script>
