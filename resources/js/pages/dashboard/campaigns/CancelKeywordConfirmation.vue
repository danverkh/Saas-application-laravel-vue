<template>
    <Modal name="cancel-keyword-confirmation" title-class="text-red-600" title="Cancel keyword">
        <div class="mt-2">Are you sure you want to cancel this keyword?</div>

        <div class="modal-action">
            <button @click="close" class="btn px-8">No</button>
            <button @click="submit" class="btn bg-red-600 border-red-700 hover:bg-red-700 hover:border-red-800">Yes, I'm sure</button>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/components/Modal.vue";
import ModalService from "@/services/Modal";
import {useDashboardCampaignStore} from "@/stores/dashboard/campaign";
import GlobalNotification from "@/services/GlobalNotification";

export default {
    name: "DeleteConfirmation",

    components: {Modal},

    methods: {
        submit() {
            const keywordId = useDashboardCampaignStore().selected.keyword.id;

            axios.delete(route('api.campaign.keyword.cancel', keywordId))
                .then(({data}) => {
                    if (data.status === 'success') {
                        // set keyword as canceled
                        this.close();
                    } else {
                        GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Failed to cancel keyword, please contact support.'});
                    }
                })
                .catch(error => {
                    console.error('Failed to submit form', error);
                    GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Please try again later.'});
                });
        },

        close() {
            ModalService.close('cancel-keyword-confirmation');
        },
    },
}
</script>
