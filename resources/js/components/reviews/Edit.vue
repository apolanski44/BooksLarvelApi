<template>
    <div class="container">
        <h2>Edytuj swoją recenzję</h2>

        <form @submit.prevent="updateReview">
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

            <button type="submit">Zapisz zmiany</button>
            <button type="button" @click="$router.push(`/books/${bookId}/reviews`)">Anuluj</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            reviewData: {
                rating: '',
                content: ''
            },
            reviewId: null,
            bookId: null
        };
    },
    methods: {
        
        async updateReview() {
            try {
                await axios.put(`/api/reviews/${this.reviewId}`, this.reviewData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });

                alert("Recenzja została zaktualizowana");
                this.$router.push(`/books/${this.bookId}/reviews`);
            } catch (error) {
                console.error("Błąd podczas edycji recenzji:", error);
                alert("Nie udało się zaktualizować recenzji");
            }
        }
    },
    mounted() {
        this.reviewId = this.$route.params.reviewId;
        this.bookId = this.$route.params.bookId;
       
    }
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    text-align: left;
}
button {
    margin-right: 10px;
}
</style>
