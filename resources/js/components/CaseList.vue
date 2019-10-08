<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Case List</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cases: []
            // loading: false
        };
    },

    methods: {
        fetchCases() {
            // this.loading = true;

            // axios.get('/api/cases')
            //     .then(function (response) {
            //         this.cases = response.data;
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });
        }
    },

    mounted() {
        console.log('Component mounted.')
    }
}
</script>
