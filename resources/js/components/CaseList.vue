<template>
    <div>
        <b-row no-gutters>
            <b-col cols="8" offset="2">
                <h2 class="float-left">
                    <fa-icon :icon="['fas', 'flag-usa']" size="2x" class="rounded mr-2 p-2" />
                    My Cases
                    <span v-cloak v-show="loading" class="ml-2">
                        <fa-icon :icon="['fas', 'circle-notch']" spin />
                    </span>
                </h2>
                <div class="float-right">
                    <b-button-group>
                        <b-button v-b-modal.modal-add-case variant="primary">
                            <fa-icon :icon="['fas', 'plus']" />
                            Add Case
                        </b-button>

                        <b-button v-b-modal.modal-import-cases variant="outline-primary" disabled>
                            <fa-icon :icon="['far', 'arrow-alt-circle-down']" />
                            Import Cases
                        </b-button>
                    </b-button-group>
                </div>
                <div class="clearfix"></div>

                <div id="cases" class="mt-4">
                    <b-card v-for="(item, key) in cases" :key="key" header-tag="header" footer-tag="footer" class="mb-3">
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
                </div>
            </b-col>
        </b-row>

        <add-case-modal @caseAdded="caseAdded" />
    </div>
</template>

<script>
export default {
    data() {
        return {
            cases: [],
            loading: false
        };
    },

    mounted() {},

    methods: {
        caseAdded(caseId) {
            this.addCase(caseId);
        },

        addCase(caseId) {
            this.loading = true;

            this.fetchCase(caseId, (caseItem, err) => {
                this.loading = false;
                if (err) return;
                this.cases.push(caseItem);
            });
        },

        fetchCase(caseId, cb) {
            axios.get('/uscis/cases/' + caseId)
                .then((response) => {
                    const caseItem = response.data;
                    console.log(caseItem);
                    cb(caseItem, null);
                })
                .catch((error) => {
                    console.log(error);
                    cb(null, error);
                });
        }
    }
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
.fa-flag-usa {
    background-image: linear-gradient(red, white, blue);
}
</style>
