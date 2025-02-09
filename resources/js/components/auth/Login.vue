<template>
    <div class="auth-container">
        <h2>Logowanie</h2>
        <form @submit.prevent="login">
            <input v-model="email" type="email" placeholder="Email">
            <input v-model="password" type="password" placeholder="Hasło">
            <button type="submit">Zaloguj</button>
            <p v-if="errorMessage">{{ errorMessage }}</p>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errorMessage: ''
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                });

                localStorage.setItem('token', response.data.token);
                alert("Zalogowano");
                this.$router.push('/');
            } catch (error) {
                this.errorMessage = "Błędne dane logowania";
                console.error("Błąd logowania:", error);
            }
        }

    }
};
</script>



<style scoped>
.auth-container {
    max-width: 400px;
    margin: auto;
    text-align: center;
}
input {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 10px;
}
button {
    padding: 10px;
    width: 100%;
}
</style>
