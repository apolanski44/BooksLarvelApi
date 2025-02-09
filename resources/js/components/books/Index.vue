<template>
    <div class="container">
        <h2>Dodaj nową książkę</h2>

        <div class="card">
            <div class="card-body">
                <form @submit.prevent="addBook">
                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input v-model="book.title" type="text" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="author">Autor</label>
                        <input v-model="book.author" type="text" id="author" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="publication_year">Rok wydania</label>
                        <input v-model.number="book.publication_year" type="number" id="publication_year" class="form-control" min="1800" :max="currentYear" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Opis (opcjonalnie)</label>
                        <textarea v-model="book.description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Dodaj książkę</button>
                </form>

                <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
                <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            book: {
                title: '',
                author: '',
                publication_year: new Date().getFullYear(),
                description: ''
            },
            errorMessage: '',
            successMessage: '',
            currentYear: new Date().getFullYear()
        };
    },
    methods: {
        async addBook() {
            try {
                this.errorMessage = '';
                this.successMessage = '';

                const response = await axios.post('/api/books', this.book, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });

                this.successMessage = "Książka została dodana";
                this.book = { title: '', author: '', publication_year: this.currentYear, description: '' };
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errorMessage = "Błąd walidacji:" + Object.values(error.response.data.errors).flat().join(", ");
                } else {
                    this.errorMessage = "Wystąpił błąd podczas dodawania książki.";
                }
            }
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 500px;
    margin: auto;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

button {
    width: 100%;
}

.error-message {
    color: red;
    font-weight: bold;
}

.success-message {
    color: green;
    font-weight: bold;
}
</style>
