<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['data-thread'],
        data() {
            return {
                repliesCount: this.dataThread.replies_count,
                locked: this.dataThread.locked,
                editing : false,
                title: this.dataThread.title,
                body: this.dataThread.body,
                form: {
                    title: this.dataThread.title,
                    body: this.dataThread.body
                }
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
            },
            update() {
                let uri = `/threads/${this.dataThread.channel.slug}/${this.dataThread.slug}`;

                 axios.patch(uri, this.form)
                     .then(() => {
                         this.title = this.form.title;
                         this.body = this.form.body;
                         this.editing = false;
                         flash("Your thread has been successfully updated!");
                     });
            },
            cancel() {
                this.editing = false;
                this.form.title = this.dataThread.title;
                this.form.body = this.dataThread.body;
            }
        }
    }
</script>