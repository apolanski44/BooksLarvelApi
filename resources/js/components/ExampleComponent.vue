<template>
    <nav>
        <router-link to="/">Strona główna</router-link>
        <router-link v-if="!isAuthenticated" to="/login">Logowanie</router-link>
        <router-link v-if="!isAuthenticated" to="/register">Rejestracja</router-link>
        <router-link to="/list">Lista książek</router-link>
        <button v-if="isAuthenticated" @click="logout">Wyloguj się</button>
    </nav>
    <router-view/>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isAuthenticated: !!localStorage.getItem('token')
        };
    },
    methods: {
        async logout() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    console.warn("Nie znaleziono tokena.");
                    return;
                }

                await axios.post('/api/logout', {}, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                localStorage.removeItem('token');
                this.$router.push('/login');
            } catch (error) {
                console.error("Błąd podczas wylogowywania:", error);
                alert("Błąd podczas wylogowywania.");
            }
        }

    },
    watch: {
        '$route'() {
            this.isAuthenticated = !!localStorage.getItem('token');
        }
    }
};
</script>

<style scoped>
nav {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}
button {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
button:hover {
    background-color: darkred;
}
</style>
