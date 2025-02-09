<template>
    <div class="container">
        <h2>Recenzje dla książki: <b>{{ bookTitle || 'Ładowanie...' }}</b></h2>

        <div class="filter-section">
            <label for="filter-rating">Filtruj recenzje według oceny:</label>
            <select id="filter-rating" v-model="filterBy" @change="fetchReviews">
                <option value="all">Wszystkie</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>
        </div>

        <div v-if="reviews.length > 0" class="review-list">
            <div v-for="review in reviews" :key="review.id" class="review-card">
                <h3>⭐ {{ review.rating }} / 5</h3>
                <p><strong>Autor:</strong> {{ review.username }}</p>
                <p>{{ review.content }}</p>

                <div v-if="isAuthenticated && review.user_id === userId" class="review-actions">
                    <button @click="$router.push({ name: 'reviews.edit', params: { bookId: bookId, reviewId: review.id } })"> Edytuj</button>
                    <button @click="deleteReview(review.id)"> Usuń</button>
                </div>
            </div>
        </div>

        <p v-else class="no-reviews">Brak recenzji dla tej książki.</p>

        <div v-if="isAuthenticated" class="add-review">
            <h3>Dodaj swoją recenzję</h3>
            <form @submit.prevent="submitReview">
                <div class="form-group">
                    <label for="review-name">Twoje imię</label>
                    <input type="text" id="review-name" v-model="reviewData.username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="rating">Ocena</label>
                    <select id="rating" v-model="reviewData.rating" class="form-control" required>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="review-text">Treść recenzji</label>
                    <textarea id="review-text" v-model="reviewData.content" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" >Dodaj recenzję</button>
            </form>
        </div>

        <p v-else class="login-info">Zaloguj się, aby dodać recenzję.</p>
    </div>
</template>



<script>
import axios from 'axios';

export default {
    data() {
        return {
            reviews: [],
            reviewData: {
                username: '',
                rating: '',
                content: ''
            },
            filterBy: 'all',
            bookId: null,
            userId: null,
            bookTitle: null,
            isAuthenticated: !!localStorage.getItem('token'),
        };
    },
    methods: {
        async fetchBookTitle(){
            try {
                const response = await axios.get(`/api/books/${this.bookId}`);
                this.bookTitle = response.data.title;
            } catch (error) {
                console.error("Błąd podczas pobierania tytułu",error);
            }
        },
        async fetchReviews() {
            try {
                const params = {};
                if (this.filterBy !== 'all') {
                    params.rating = this.filterBy;
                }

                const response = await axios.get(`/api/books/${this.bookId}/reviews`, { params });
                this.reviews = response.data;
            } catch (error) {
                console.error("Błąd podczas pobierania recenzji:", error);
            }
        },
        async submitReview() {
            try {
                await axios.post(`/api/books/${this.bookId}/reviews`, this.reviewData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });

                this.reviewData = { username: '', rating: '', content: '' };
                this.fetchReviews();
            } catch (error) {
                console.error("Błąd podczas dodawania recenzji:", error);
            }
        },
        async deleteReview(reviewId) {
            if (!confirm("Czy na pewno chcesz usunąć tę recenzję?")) return;

            try {
                await axios.delete(`/api/reviews/${reviewId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });

                this.reviews = this.reviews.filter(review => review.id !== reviewId);
            } catch (error) {
                console.error("Błąd podczas usuwania recenzji:", error);
            }
        },

       
    },
    async mounted() {
        this.bookId = this.$route.params.id;
        await this.fetchReviews();
       
        await this.fetchBookTitle(); 
        
    

        if (this.isAuthenticated) {
            try {
                const response = await axios.get('/api/user', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.userId = response.data.id;
            } catch (error) {
                console.error("Błąd podczas pobierania ID użytkownika:", error);
            }
        }
    }
};
</script>



<style scoped>
.container {
    max-width: 800px;
    margin: auto;
    text-align: center;
}

.sort-section {
    margin-bottom: 20px;
}

.review-card {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    background: #f9f9f9;
}

.add-review {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ddd;
    background: #f1f1f1;
}

button {
    cursor: pointer;
}

.no-reviews {
    color: #777;
}
</style>
