<template>
    <b-modal @ok="handleOk" @shown="focusInput" @hidden="resetModal" :okDisabled="loading" :cancelDisabled="loading" ref="modal" id="modal-add-case" title="Add Case" buttonSize="lg" okTitle="Add Case" centered>
        <b-form @submit.stop.prevent="onFormSubmit" ref="form">
            <b-form-group label="Case Number" label-for="case-number" label-size="lg">
                <b-form-input v-model="caseId" type="text" size="lg" ref="caseNumber" id="case-number" placeholder="ABC1234567890" trim required />
                <b-form-invalid-feedback v-cloak v-if="errors && errors.caseNumber" :force-show="true">{{ errors.caseNumber[0] }}</b-form-invalid-feedback>
                <b-form-text v-cloak v-else>The receipt number for your case from USCIS.</b-form-text>
            </b-form-group>
        </b-form>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            caseId: "",
            loading: false,
            errors: {}
        };
    },

    mounted() {},

    methods: {
        focusInput() {
            this.$refs.caseNumber.focus();
        },

        resetModal() {
            this.caseId = "";
            this.loading = false;
            this.errors = {};
        },

        onFormSubmit() {
            this.addCase();
        },

        handleOk($event) {
            $event.preventDefault();

            this.addCase();
        },

        addCase() {
            this.loading = true;
            const caseId = this.caseId;

            this.$parent.fetchCase(caseId, (caseItem, error) => {
                this.loading = false;

                if (error) {
                    const response = error.response;
                    if (response.status === 422) {
                        this.errors = response.data.errors;
                    }
                }
                else {
                    this.$emit('caseAdded', caseItem);

                    this.$nextTick(() => {
                        this.$refs.modal.hide();
                    });
                }
            });
        }
    }
}
</script>
