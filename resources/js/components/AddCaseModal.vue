<template>
    <b-modal @shown="focusInput" ref="modal" id="modal-add-case" title="Add Case" buttonSize="lg" okTitle="Add Case" centered>
        <b-form @submit.prevent="addCase">
            <b-form-group label="Case Number" label-for="case-number" label-size="lg" description="The receipt number for your case from USCIS.">
                <b-form-input v-model="caseId" type="text" size="lg" ref="caseNumber" id="case-number" placeholder="ABC1234567890" required />
            </b-form-group>
        </b-form>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            caseId: ""
        };
    },

    mounted() {},

    methods: {
        focusInput() {
            this.$refs.caseNumber.focus();
        },

        addCase() {
            const caseId = this.caseId;
            this.$emit('caseAdded', caseId);
            this.$bvModal.hide('modal-add-case');
            this.caseId = "";
        }
    }
}
</script>
