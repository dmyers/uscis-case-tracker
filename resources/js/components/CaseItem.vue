<template>
    <b-card header-tag="header" footer-tag="footer" class="mb-3">
        <template v-slot:header>
            <h5 class="float-left card-heading mb-0">
                <span class="text-muted"><strong>Case</strong> #</span>{{ item.id }}
            </h5>

            <b-badge :variant="statusVariant" class="px-2 py-1 float-right">
                <span class="case-title">{{ item.title }}</span>
            </b-badge>

            <div class="clearfix"></div>
        </template>

        <b-card-text>
            <p class="m-0 p-0">{{ item.details }}</p>
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

    computed: {
        statusVariant() {
            if (this.item.status_code === 'complete') {
                return 'success';
            }
            else if (this.item.status_code === 'pending') {
                return 'warning';
            }
            else {
                return null;
            }
        }
    },

    methods: {}
}
</script>

<style lang="scss">
.card footer {
    padding-top: 0.25rem;
    padding-bottom: 0.4rem;
}
.card-header .case-title {
    font-size: 150%;
}
.card-body p {
    font-size: 0.8rem;
    line-height: 18px;
}
</style>
