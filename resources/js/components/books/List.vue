<template>
    <div class="container">
        <h2>Lista książek</h2>

        <div class="sort-section">
            <label for="sort-by">Sortuj według:</label>
            <select id="sort-by" v-model="sortBy" @change="fetchBooks">
                <option value="title">Tytuł</option>
                <option value="author">Autor</option>
                <option value="publication_year">Rok wydania</option>
            </select>
        </div>

        <div v-if="books.length" class="book-list">
            <div v-for="book in books" :key="book.id" class="book-card">
                <h3><b>{{ book.title }}</b></h3>
                <p><strong>Autor:</strong> {{ book.author }}</p>
                <p><strong>Rok wydania:</strong> {{ book.publication_year }}</p>
                <p v-if="book.description"><strong>Opis:</strong> {{ book.description }}</p>
                
                <button @click="goToReviews(book.id)" class="btn btn-info">Zobacz recenzje</button>
            </div>
        </div>

        <p v-else>Nie znaleziono żadnych książek.</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            books: [],
            sortBy: 'title'
        };
    },
    methods: {
        async fetchBooks() {
            try {
                const response = await axios.get('/api/books', {
                    params: { sort_by: this.sortBy }
                });
                this.books = response.data;
            } catch (error) {
                console.error("Błąd podczas pobierania książek:", error);
            }
        },
        goToReviews(bookId) {
            this.$router.push(`/books/${bookId}/reviews`);
        }
    },
    mounted() {
        this.fetchBooks();
    }
};
</script>

<style scoped>
.container {
    max-width: 700px;
    margin: auto;
    text-align: center;
}

.sort-section {
    margin-bottom: 20px;
}

.book-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.book-card {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    background: #f9f9f9;
    text-align: left;
}

button {
    margin-top: 10px;
}
</style>
