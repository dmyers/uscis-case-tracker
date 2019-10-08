<template>
    <b-card header-tag="header" footer-tag="footer" class="mb-3">
        <template v-slot:header>
            <h5 class="float-left card-heading mb-0">
                <span class="text-muted"><strong>Case</strong> #</span>{{ item.id }}
            </h5>

            <b-badge class="float-right">
                <span class="case-title">
                    {{ item.title }}
                </span>
            </b-badge>

            <div class="clearfix"></div>
        </template>

        <b-card-text>
            <p class="m-0 p-0">
                {{ item.details }}
            </p>
        </b-card-text>

        <template v-slot:footer>
            <div class="text-center text-muted">
                <small>
                    Last Updated: {{ item.date | moment("dddd, MMMM Do YYYY") }}
                </small>
            </div>
        </template>
    </b-card>
</template>

<script>
export default {
    props: ['item'],

    data() {
        return {};
    },

    mounted() {},

    methods: {}
}
</script>
