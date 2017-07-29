<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <label for="body">Add a Comment</label>
                <textarea class="form-control"
                          id="body"
                          name="body"
                          rows="5"
                          placeholder="Have something to say?"
                          required
                          v-model="body"></textarea>
            </div>
            <div class="form-group">
                <button type="submit"
                        class="btn btn-primary btn-block"
                        @click="addReply">Submit
                </button>
            </div>
        </div>
        <p class="text-center" v-else>Please, <a href="/login">log in</a> to participate in this
        discussion.</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: ''
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>