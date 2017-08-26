<template>
    <div class="form-group">
        <input type="file" accept="image/*" @change="onChange">
    </div>
</template>

<script>
    export default {
        methods: {
            onChange(event) {
                if (! event.target.files.length) return;

                let file = event.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = event => {
                    let src = event.target.result;
                    this.$emit('loaded', {src, file});
                };
            },
        }
    }
</script>