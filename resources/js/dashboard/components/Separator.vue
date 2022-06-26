<template>
    <span v-if="show"><slot></slot></span>
</template>
<script>
export default {
    name: 'Separator',
    props: ['items', 'index'],
    computed: {
        show() {
            return this.index !== (Array.isArray(this.items) ? this.items : Object.keys(this.items)).length - 1
        }
    }
}
</script>
