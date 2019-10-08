<template>
    <div>
        <b-row no-gutters>
            <b-col lg="8" offset-lg="2" sm="12" offset-sm="0">
                <h2 class="h2 float-left">
                    <fa-icon :icon="['fas', 'flag-usa']" size="2x" class="rounded mr-2 p-2" />
                    My Cases
                    <fa-icon v-cloak v-show="loading" :icon="['fas', 'circle-notch']" class="ml-2" spin />
                </h2>

                <div class="float-right">
                    <b-button-group>
                        <b-button v-b-modal.modal-add-case variant="primary">
                            <fa-icon :icon="['fas', 'plus']" class="mr-1" />
                            Add Case
                        </b-button>

                        <b-button v-b-modal.modal-import-cases variant="outline-primary" disabled>
                            <fa-icon :icon="['far', 'arrow-alt-circle-down']" class="mr-1" />
                            Import Cases
                        </b-button>
                    </b-button-group>
                </div>
                <div class="clearfix"></div>

                <div class="mt-4">
                    <div v-cloak v-show="emptyCases">
                        <b-alert variant="warning" show>
                            <div class="p-4 text-center">
                                <h5 class="h5 mb-4">
                                    You currently have no linked cases to view.
                                </h5>

                                <b-row>
                                    <b-col lg="4" offset-lg="4" sm="12" offset-sm="0">
                                        <b-button v-b-modal.modal-add-case variant="secondary" size="lg" block>
                                            <fa-icon :icon="['fas', 'plus']" />
                                            Add Case
                                        </b-button>
                                    </b-col>
                                </b-row>
                            </div>
                        </b-alert>
                    </div>

                    <div v-cloak v-show="!emptyCases" id="cases">
                        <case-item v-for="(item, index) in cases" :key="item.id" :item="item" @reloadCase="updateCase(index, item.caseNumber)" />
                    </div>
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

    computed: {
        emptyCases() {
            return this.cases.length == 0;
        }
    },

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

        updateCase(index, caseId) {
            this.loading = true;

            this.fetchCase(caseId, (caseItem, err) => {
                this.loading = false;
                if (err) return;
                this.cases[index] = caseItem;
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
.h2 {
    font-weight: 900 !important;
    letter-spacing: -1px;
}
.fa-flag-usa {
    background-image: linear-gradient(red, white, blue);
}
</style>
