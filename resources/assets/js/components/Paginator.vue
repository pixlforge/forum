<template>
    <ul class="pagination" v-if="shouldPaginate" aria-label="Page navigation">
        <li class="page-item" v-show="prevUrl">
            <a href="#" class="page-link" rel="prev" @click.prevent="page--" aria-label="Previous">
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>
        <li class="page-item" v-show="nextUrl">
            <a href="#" class="page-link" rel="next" @click.prevent="page++" aria-label="Next">
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        watch: {
            dataSet() {
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>