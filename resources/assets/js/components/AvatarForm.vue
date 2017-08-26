<template>
    <div class="col-6 col-lg-2">
        <img :src="avatar" class="img-fluid rounded mb-4" alt="Avatar">
        <form action=""
              enctype="multipart/form-data"
              v-if="canUpdate">
            <app-image-upload name="avatar" @loaded="onLoad"></app-image-upload>
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user'],
        data() {
            return {
                avatar: '/storage/' + this.user.avatar_path
            };
        },
        components: {
            'app-image-upload': ImageUpload
        },
        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            }
        },
        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },
            persist(avatar) {
                let data = new FormData();
                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'))
                    .catch(error => console.log(error.response.message));
            }
        }
    }
</script>