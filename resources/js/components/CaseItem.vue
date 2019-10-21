<template>
    <b-card class="mb-3" no-body>
        <header @click="open = !open" :class="{'card-header-open': open }" class="card-header p-3">
            <h5 class="float-md-left card-heading mb-0">
                <fa-icon v-cloak v-show="open" :icon="['fas', 'chevron-down']" size="sm" class="mr-1" />

                <fa-icon v-cloak v-show="!open" :icon="['fas', 'chevron-right']" size="sm" class="mr-1" />

                <span class="text-muted">
                    <strong>Case</strong> #
                </span>

                {{ item.caseNumber }}

                <b-badge v-if="item.form" variant="primary" class="ml-2">{{ item.form }}</b-badge>
            </h5>

            <div class="float-md-right">
                <b-badge :variant="statusVariant" class="px-2 py-1">
                    <span class="case-status">{{ item.status }}</span>
                </b-badge>

                <a @click.stop.prevent="reload($event)" href="javascript:void(0)" class="ml-2">
                    <fa-icon :icon="['fas', 'redo-alt']" size="sm" />
                </a>

                <a v-cloak v-if="item.tracking" @click.stop.prevent="openTracking" href="javascript:void(0)" class="ml-2">
                    <fa-icon :icon="['fas', 'shipping-fast']" size="sm" />
                </a>
            </div>

            <div class="clearfix"></div>
        </header>

        <b-card-body v-cloak v-if="open">
            <b-card-text>
                <h5 class="h5 text-center">{{ item.title }}</h5>
                <p v-html="item.details_raw" class="m-0 p-0"></p>
            </b-card-text>
        </b-card-body>

        <footer v-cloak v-if="open" class="card-footer">
            <div class="text-center text-muted">
                <small>
                    <fa-icon :icon="['far', 'calendar-alt']" class="mr-1" />
                    Last status change:
                    <span>{{ item.date | moment("from", "now") }}</span>
                    <!-- <span>{{ item.date | moment("dddd, MMMM Do YYYY") }}</span> -->
                </small>
            </div>
        </footer>
    </b-card>
</template>

<script>
export default {
    props: ['item'],

    data: () => ({
        open: false
    }),

    created() {},

    mounted() {},

    computed: {
        trackingUrl() {
            return 'https://tools.usps.com/go/TrackConfirmAction?tLabels=' + this.item.tracking;
        },

        statusVariant() {
            if (this.item.status_code === 'complete') {
                return 'success';
            }
            else if (this.item.status_code === 'pending') {
                return 'warning';
            }
            else if (this.item.status_code === 'failed') {
                return 'danger';
            }
            else {
                return null;
            }
        }
    },

    methods: {
        openTracking($event) {
            $event.preventDefault();
            $event.stopPropagation();

            window.open(this.trackingUrl);
        },

        reload($event) {
            $event.preventDefault();
            $event.stopPropagation();

            this.$emit('reloadCase', this.item.caseNumber);
        }
    }
}
</script>

<style lang="scss">
.card {
    border-width: 2px !important;

    .card-header {
        cursor: pointer;
        border-width: 0;

        &.card-header-open {
            border-width: 1px;
        }
        .case-status {
            font-size: 150%;
        }
    }
    .card-body p {
        font-size: 15px;
        line-height: 22px;
    }
    .card-footer {
        padding-top: 0.25rem;
        padding-bottom: 0.4rem;
    }
}
</style>
