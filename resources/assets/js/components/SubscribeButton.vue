<template>
    <button :class="classes" role="button" @click="subscribe" v-text="label"></button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-danger' : 'btn-success'];
            },

            label() {
                return this.active ? 'Unsubscribe' : 'Subscribe';
            }
        },

        methods: {
            subscribe() {
                axios[(this.active ? 'delete' : 'post')](location.pathname + "/subscriptions");

                this.active = ! this.active;

                flash(this.active ? 'Subscribed' : 'Unsubscribed');
            }
        }
    }
</script>