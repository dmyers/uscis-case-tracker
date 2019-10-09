<template>
    <b-row class="mt-3">
        <b-col cols="12" class="text-center text-muted">
            made with
            <fa-icon :icon="['fas', 'heart']" size="sm" class="ml-1 mr-1" />
            for my
            <span class="symbol-pi ml-1">&pi;</span>
        </b-col>
    </b-row>
</template>

<script>
export default {
    data: () => ({}),

    created() {},

    mounted() {},

    computed: {},

    methods: {}
}
</script>

<style lang="scss">
.fa-heart {
    color: #ce1f1f;
}
.symbol-pi {
    font-size: 20px;
    font-weight: 700;
    color: #333;
}
</style>
