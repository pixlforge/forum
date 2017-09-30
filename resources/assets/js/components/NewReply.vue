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
    import 'jquery.caret';
    import 'at.js';

    export default {
        data() {
            return {
                body: ''
            }
        },
        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        $.getJSON("/api/users", {name: query}, function (usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        },
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .then(({data}) => {
                        this.body = '';
                        flash('Your reply has been posted.');
                        this.$emit('created', data);
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
            }
        }
    }
</script>