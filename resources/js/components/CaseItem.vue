<template>
    <b-card class="mb-3" no-body>
        <header @click="open = !open" :class="{'card-header-open': open }" class="card-header">
            <h5 class="float-left card-heading mb-0">
                <fa-icon v-cloak v-show="open" :icon="['fas', 'chevron-down']" size="sm" class="mr-1" />
                <fa-icon v-cloak v-show="!open" :icon="['fas', 'chevron-right']" size="sm" class="mr-1" />
                <span class="text-muted"><strong>Case</strong> #</span>{{ item.id }}
            </h5>

            <b-badge :variant="statusVariant" class="px-2 py-1 float-right">
                <span class="case-title">{{ item.title }}</span>
            </b-badge>

            <div class="clearfix"></div>
        </header>

        <div v-cloak v-if="open">
            <b-card-body>
                <b-card-text>
                    <p class="m-0 p-0">{{ item.details }}</p>
                </b-card-text>
            </b-card-body>
        </div>

        <footer v-cloak v-if="open" class="card-footer">
            <div class="text-center text-muted">
                <small>
                    Last Updated: {{ item.date | moment("dddd, MMMM Do YYYY") }}
                </small>
            </div>
        </footer>
    </b-card>
</template>

<script>
export default {
    props: ['item'],

    data() {
        return {
            open: false
        };
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
.card {
    .card-header {
        cursor: pointer;
        border-width: 0;

        &.card-header-open {
            border-width: 1px;
        }
        .case-title {
            font-size: 150%;
        }
    }
    .card-body p {
        font-size: 0.8rem;
        line-height: 18px;
    }
    .card-footer {
        padding-top: 0.25rem;
        padding-bottom: 0.4rem;
    }
}
</style>
