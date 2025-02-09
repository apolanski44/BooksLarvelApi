<template>
    <div class="auth-container">
        <h2>Rejestracja</h2>
        <form @submit.prevent="register">
            <input v-model="name" type="text" placeholder="Imię">
            <input v-model="email" type="email" placeholder="Email">
            <input v-model="password" type="password" placeholder="Hasło">
            <input v-model="password_confirmation" type="password" placeholder="Potwierdź hasło">
            <button type="submit">Zarejestruj</button>
            <p v-if="errorMessage">{{ errorMessage }}</p>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errorMessage: ''
        };
    },
    methods: {
        async register() {
            try {
                await axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                });
                alert("Zarejestrowano");
                this.$router.push('/login');
            } catch (error) {
                this.errorMessage = "Błąd rejestracji";
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
