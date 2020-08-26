<template>
    <div>
        <div class="container">
            <component :is="layout">
                <router-view></router-view>
            </component>
        </div>
    </div>
</template>
<script>
    const defaultLayout = 'default'

    export default {
        computed: {
            layout () {
                return (this.$route.meta.layout || defaultLayout) + '-layout'
            },
            created () {
                console.log(this.$route, this.$route.meta.layout)
            },
            updated () {
                console.log(this.$route, this.$route.meta.layout)
            }
        }
    }
</script>