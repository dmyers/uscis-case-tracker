<template>
    <div>
        <b-row no-gutters>
            <b-col lg="8" offset-lg="2" sm="12" offset-sm="0">
                <h2 class="h2 float-left">
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
                    <case-item v-for="(item, key) in cases" :key="key" :item="item" />
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
.h2 {
    font-weight: 900 !important;
    letter-spacing: -1px;
}
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
