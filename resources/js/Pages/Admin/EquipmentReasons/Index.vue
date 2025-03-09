<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import AdminLayout from "../Components/AdminLayout.vue";
import { Search, Plus, Edit, Delete } from "@element-plus/icons-vue";

// Props from Laravel Inertia
const props = defineProps({ reasons: Array });

const showModal = ref(false);
const searchQuery = ref("");
const editingReasonId = ref(null);

const form = useForm({
    reason_type: "",
    description: "",
});

// Computed property for filtering search results
const filteredReasons = computed(() =>
    props.reasons.filter(
        (reason) =>
            (reason.reason_type ?? "").toLowerCase().includes((searchQuery.value ?? "").toLowerCase()) ||
            (reason.description ?? "").toLowerCase().includes((searchQuery.value ?? "").toLowerCase())
    )
);

const modalTitle = computed(() => (editingReasonId.value ? "Edit Reason" : "Add Reason"));
const modalButton = computed(() => (editingReasonId.value ? "Update" : "Save"));

// Open modal for Add/Edit
const openModal = (reason) => {
    if (reason) {
        editingReasonId.value = reason.id;
        form.reason_type = reason.reason_type;
        form.description = reason.description;
    } else {
        editingReasonId.value = null;
        form.reset();
    }
    showModal.value = true;
};

// Submit Form
const submit = () => {
    if (editingReasonId.value) {
        form.put(route("equipment-reasons.update", editingReasonId.value), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage({ message: "Equipment reason updated successfully", type: "success" });
            },
        });
    } else {
        form.post(route("equipment-reasons.store"), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage({ message: "Equipment reason added successfully", type: "success" });
            },
        });
    }
};

// Confirm delete reason
const confirmDelete = (id) => {
    ElMessageBox.confirm("Are you sure you want to delete this equipment reason?", "Warning", {
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        type: "warning",
    })
        .then(() => {
            form.delete(route("equipment-reasons.destroy", id), {
                onSuccess: () => ElMessage({ message: "Equipment reason deleted successfully", type: "success" }),
            });
        })
        .catch(() => {});
};
</script>

<template>
    <AdminLayout>
        <section class="bg-gray-50 dark:bg-gray-900 p-5">
            <div class="row">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
                    <h2 class="text-xl font-semibold">Equipment Reasons</h2>
                    <div class="flex items-center space-x-3">
                        <el-input
                            v-model="searchQuery"
                            placeholder="Search for a reason..."
                            class="w-64"
                            clearable
                        >
                            <template #prefix>
                                <el-icon><Search /></el-icon>
                            </template>
                        </el-input>
                        <el-button type="primary" @click="openModal(null)">
                            <el-icon><Plus /></el-icon> Add Reason
                        </el-button>
                    </div>
                </div>

                <!-- Table Section -->
                <el-table :data="filteredReasons" stripe highlight-current-row border style="width: 100%">
                    <el-table-column prop="reason_type" label="Type" sortable />
                    <el-table-column prop="description" label="Description" sortable />
                    <el-table-column label="Actions" width="160">
                        <template #default="{ row }">
                            <el-tooltip content="Edit" placement="top">
                                <el-button size="small" @click="openModal(row)">
                                    <el-icon><Edit /></el-icon>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Delete" placement="top">
                                <el-button size="small" type="danger" @click="confirmDelete(row.id)">
                                    <el-icon><Delete /></el-icon>
                                </el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>

                <!-- Modal Popup for Add/Edit -->
                <el-dialog v-model="showModal" :title="modalTitle" width="450px" center>
                    <el-form :model="form" label-width="100px">
                        <el-form-item label="Type">
                            <el-select v-model="form.reason_type" placeholder="Select Type">
                                <el-option label="Assignment" value="assignment" />
                                <el-option label="Return" value="return" />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Description">
                            <el-input v-model="form.description" clearable placeholder="Enter description" />
                        </el-form-item>
                    </el-form>
                    <template #footer>
                        <el-button @click="showModal = false">Cancel</el-button>
                        <el-button type="primary" @click="submit">{{ modalButton }}</el-button>
                    </template>
                </el-dialog>
            </div>
        </section>
    </AdminLayout>
</template>
