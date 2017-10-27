<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['data-thread'],
        data() {
            return {
                repliesCount: this.dataThread.replies_count,
                locked: this.dataThread.locked
            }
        },
        components: {
            Replies,
            SubscribeButton
        },
        methods: {
            toggleLock() {
                if (this.locked == false) {
                    this.locked = true;
                    axios.post('/locked-threads/' + this.dataThread.slug);
                } else {
                    this.locked = false;
                    axios.delete('/locked-threads/' + this.dataThread.slug);
                }
            }
        }
    }
</script>