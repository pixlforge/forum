<template>
    <div class="card my-4">
        <div :id="'reply-' + id"
             class="card-header d-flex justify-content-between"
             :class="isBest ? 'bg-success' : ''">
            <div class="d-flex flex-column">
                <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name"></a>
                <small>
                    <span v-text="ago"></span>
                </small>
            </div>
            <div class="d-flex align-items-baseline">
                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
                <div v-if="authorize('owns', reply)">
                    <button class="btn btn-transparent"
                            @click="editing = true">
                        <i class="fa fa-pencil fa-lg"></i>
                    </button>
                    <button class="btn btn-transparent"
                            @click="destroy">
                        <i class="fa fa-times fa-lg close-red"></i>
                    </button>
                    <button class="btn btn-transparent"
                            @click="markBestReply"
                            v-if="authorize('owns', reply.thread)">
                        <i class="fa fa-check-circle fa-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        <form @submit.prevent="update">
            <div class="card-block">
                <div class="form-group" v-if="editing">
                    <textarea class="form-control" v-model="body" required></textarea>
                </div>
                <div v-else v-html="body"></div>
            </div>
            <div class="card-footer" v-if="editing">
                <div class="form-group mt-3">
                    <button class="btn btn-primary btn-sm"
                            type="submit">Update</button>
                    <button class="btn btn-default btn-sm"
                            type="button"
                            @click="editing = false">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],
        data() {
            return {
                editing: false,
                id: this.id,
                body: this.reply.body,
                isBest: this.reply.isBest
            };
        },
        components: {Favorite},
        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },
        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow();
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
                this.editing = false;
                flash('The reply was updated successfully!');
            },
            destroy() {
                axios.delete('/replies/' + this.id);
                this.$emit('deleted', this.id);
            },
            markBestReply() {
                axios.post('/replies/' + this.id + '/best');
                window.events.$emit('best-reply-selected', this.id);
            }
        },
    }
</script>