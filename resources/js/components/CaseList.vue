<template>
    <div>
        <b-row no-gutters>
            <b-col lg="8" offset-lg="2" sm="12" offset-sm="0">
                <h2 class="h2 float-left">
                    <fa-icon :icon="['fas', 'flag-usa']" size="xs" class="rounded mr-2" size-old="2x" class-old="p-2" />
                    My Cases
                    <fa-icon v-cloak v-show="loading" :icon="['fas', 'circle-notch']" size="xs" class="ml-2" spin />
                </h2>

                <div class="float-right">
                    <!-- <b-button-group> -->
                        <b-button v-b-modal.modal-add-case variant="primary">
                            <fa-icon :icon="['fas', 'plus']" class="mr-1" />
                            Add Case
                        </b-button>

                        <!-- <b-button v-b-modal.modal-import-cases variant="outline-primary" disabled>
                            <fa-icon :icon="['far', 'arrow-alt-circle-down']" class="mr-1" />
                            Import Cases
                        </b-button> -->
                    <!-- </b-button-group> -->
                </div>
                <div class="clearfix"></div>

                <div class="mt-4">
                    <div v-cloak v-show="emptyCases">
                        <b-alert variant="warning" show>
                            <div class="p-4 text-center">
                                <h5 class="h5 mb-4">
                                    You do not currently have any cases.
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
                        <case-item v-for="(item, index) in cases" :key="item.caseNumber" :item="item" @reloadCase="updateCase(index, item.caseNumber)" />
                    </div>
                </div>
            </b-col>
        </b-row>

        <made-with />
        <add-case-modal @caseAdded="appendCaseItem" />
    </div>
</template>

<script>
export default {
    data: () => ({
        cases: [],
        loading: false
    }),

    created() {},

    mounted() {
        this.loadCasesWindow();
        this.loadCasesStorage();
    },

    watch: {
        cases: {
            handler() {
                const caseIds = this.caseIds;
                const caseList = { caseIds: caseIds };
                const encodedCaseIds = JSON.stringify(caseList);
                localStorage.setItem('caseIds', encodedCaseIds);
            },

            deep: true
        }
    },

    computed: {
        caseIds() {
            const cases = this.cases;
            var caseIds = [];

            _.each(cases, caseItem => {
                caseIds.push(caseItem.caseNumber);
            });

            return caseIds;
        },

        emptyCases() {
            return this.cases.length == 0;
        }
    },

    methods: {
        hasCaseItem(caseItem) {
            return _.includes(this.caseIds, caseItem.caseNumber);
        },

        appendCaseItem(caseItem) {
            if (this.hasCaseItem(caseItem)) return;
            this.cases.push(caseItem);
        },

        addCase(caseId) {
            this.loading = true;

            this.fetchCase(caseId, (caseItem, err) => {
                this.loading = false;
                if (err) return;
                this.appendCaseItem(caseItem);
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
            axios.get('uscis/cases/' + caseId)
                .then((response) => {
                    const caseItem = response.data;
                    cb(caseItem, null);
                })
                .catch((error) => {
                    console.error(error);
                    cb(null, error);
                });
        },

        loadCasesWindow() {
            const caseIds = window.App.case_ids;
            if (caseIds) {
                _.each(caseIds, caseId => {
                    this.addCase(caseId);
                });
            }
        },

        loadCasesStorage() {
            const caseIdList = localStorage.getItem('caseIds');
            if (caseIdList) {
                const decodedCaseList = JSON.parse(caseIdList);
                const caseIds = decodedCaseList.caseIds;
                _.each(caseIds, caseId => {
                    this.addCase(caseId);
                });
            }
        }
    }
}
</script>

<style lang="scss">
.h2 {
    font-weight: 900 !important;
    letter-spacing: -1px;
}
// .fa-flag-usa {
    // background-image: linear-gradient(red, white, blue);
// }
</style>
