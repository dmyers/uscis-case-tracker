<template>
    <b-modal @ok="handleOk" @shown="focusInput" @hidden="resetModal" :okDisabled="loading" :cancelDisabled="loading" ref="modal" id="modal-add-case" title="Add Case" buttonSize="lg" okTitle="Add Case" centered>
        <b-form @submit.stop.prevent="onFormSubmit" ref="form">
            <b-form-group label="Case Number" label-for="case-number" label-size="lg">
                <b-form-input @keyup.stop.enter="onFormSubmit" @keypress="filterCaseInput($event)" v-model="caseId" :class="{ 'is-invalid': hasError('caseNumber') }" type="text" size="lg" ref="caseNumber" id="case-number" placeholder="ABC1234567890" maxlength="13" trim required />
                <b-form-invalid-feedback v-cloak v-if="hasError('caseNumber')" :force-show="true">
                    {{ firstError('caseNumber') }}
                </b-form-invalid-feedback>
                <b-form-text v-cloak v-else>
                    The receipt number for your case from USCIS.
                </b-form-text>
            </b-form-group>
        </b-form>

        <template v-slot:modal-footer="{ ok, cancel, hide }">
            <b-button @click="ok" variant="primary" size="lg" block>
                <fa-icon :icon="['fas', 'plus']" class="mr-1" />
                Add Case
            </b-button>
        </template>
    </b-modal>
</template>

<script>
import { Errors } from 'form-backend-validation';

export default {
    data: () => ({
        caseId: "",
        loading: false,
        errors: new Errors()
    }),

    created() {},

    mounted() {},

    methods: {
        hasError(field) {
            return this.errors.has(field);
        },

        firstError(field) {
            if (this.hasError) {
                return this.errors.first(field);
            }
        },

        focusInput() {
            this.$refs.caseNumber.focus();
        },

        resetModal() {
            this.caseId = "";
            this.loading = false;
            this.errors = new Errors();
        },

        filterCaseInput($event) {
            const value = this.caseId;
            const charCode = $event.which || $event.keyCode;
            const keyValue = String.fromCharCode(charCode);
            var regex;

            if (value.length < 3) {
                const alphaRegex = new RegExp("^[a-zA-Z*]+$");
                regex = alphaRegex;
            }
            else {
                const numericRegex = new RegExp("^[0-9*]+$");
                regex = numericRegex;
            }

            if (regex.test(keyValue)) {
                return true;
            }
            else {
                $event.preventDefault();
                return false;
            }
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
                        this.errors = new Errors(response.data.errors);
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
