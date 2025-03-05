<template>
    <AdminLayout>
        <section class="bg-gray-50 dark:bg-gray-900 p-5">
            <div class="row">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
                    <h2 class="text-xl font-semibold">Users Management</h2>
                    <div class="flex items-center space-x-3">
                        <el-input
                            v-model="searchQuery"
                            placeholder="Search for a user..."
                            class="w-64"
                            clearable
                        >
                            <template #prefix>
                                <el-icon><Search /></el-icon>
                            </template>
                        </el-input>
                        <el-button type="primary" @click="openModal(null)">
                            <el-icon><Plus /></el-icon> Add User
                        </el-button>
                        <el-button v-if="selectedUsers.length > 0" type="danger" @click="confirmBulkDelete">
                            <el-icon><Delete /></el-icon> Delete Selected
                        </el-button>
                    </div>
                </div>

                <!-- Table Section -->
                <el-table
                    :data="paginatedUsers"
                    stripe
                    highlight-current-row
                    border
                    style="width: 100%"
                    @selection-change="handleSelection"
                >
                    <el-table-column type="selection" width="55" />
                    <el-table-column prop="name" label="Name" sortable />
                    <el-table-column prop="email" label="Email" sortable />
                    <el-table-column prop="username" label="Username" sortable />
                    <el-table-column label="Role" sortable>
                        <template #default="{ row }">
                            <el-tag :type="getRoleTag(row.role)">{{ formatRole(row.role) }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="site.name" label="Site" sortable />
                    <el-table-column label="Actions" width="180">
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

                <!-- Pagination -->
                <div class="flex justify-end mt-5">
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        :total="filteredUsers.length"
                        :page-size="pageSize"
                        @current-change="handlePageChange"
                    />
                </div>

                <!-- Modal Popup for Add/Edit -->
                <el-dialog v-model="showModal" :title="modalTitle" width="450px" center>
    <el-form :model="form" ref="formRef" :rules="rules" label-width="100px">
        <el-form-item label="Name" prop="name">
            <el-input v-model="form.name" clearable placeholder="Enter user name" />
        </el-form-item>
        <el-form-item label="Email" prop="email">
            <el-input v-model="form.email" clearable placeholder="Enter email" />
        </el-form-item>
        <el-form-item label="Username" prop="username">
            <el-input v-model="form.username" clearable placeholder="Enter username" />
        </el-form-item>
        <el-form-item label="Password">
            <el-input v-model="form.password" clearable type="password" placeholder="Enter password" />
        </el-form-item>
        <el-form-item label="Role" prop="role">
            <el-select v-model="form.role" placeholder="Select role">
                <el-option label="Super Admin" value="super_admin" />
                <el-option label="Manager" value="manager" />
                <el-option label="Employee" value="employee" />
                <el-option label="Superior Hierarchique" value="superior_hierarchique" />
            </el-select>
        </el-form-item>
        <el-form-item label="Site">
            <el-select v-model="form.site_id" placeholder="Select site">
                <el-option v-for="site in sites" :key="site.id" :label="site.name" :value="site.id" />
            </el-select>
        </el-form-item>
    </el-form>

    <template #footer>
        <el-button @click="showModal = false">Cancel</el-button>
        <el-button type="primary" :loading="isSubmitting" @click="submit">
            {{ modalButton }} Confirme
        </el-button>
    </template>
</el-dialog>

            </div>
        </section>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import AdminLayout from "../Components/AdminLayout.vue";
import { Search, Plus, Edit, Delete } from "@element-plus/icons-vue";

const props = defineProps({
    users: Array,
    sites: Array,
});

const showModal = ref(false);
const searchQuery = ref("");
const isSubmitting = ref(false);

const editingUserId = ref(null);
const formRef = ref(null);
const selectedUsers = ref([]);
const currentPage = ref(1);
const pageSize = 20; // Changed to 20 users per page

const form = useForm({
    name: "",
    email: "",
    username: "",
    password: "",
    role: "",
    site_id: null,
});

// Validation Rules
const rules = {
    name: [{ required: true, message: "Name is required", trigger: "blur" }],
    email: [{ required: true, type: "email", message: "Valid email required", trigger: "blur" }],
    role: [{ required: true, message: "Role is required", trigger: "change" }],
};
const submit = () => {
    formRef.value.validate((valid) => {
        if (!valid) return; // Prevent submission if form is invalid

        isSubmitting.value = true;

        if (editingUserId.value) {
            form.put(route("users.update", editingUserId.value), {
                onSuccess: () => {
                    showModal.value = false;
                    isSubmitting.value = false;
                    ElMessage({ message: "User updated successfully", type: "success" });
                },
                onError: () => (isSubmitting.value = false),
            });
        } else {
            form.post(route("users.store"), {
                onSuccess: () => {
                    showModal.value = false;
                    isSubmitting.value = false;
                    ElMessage({ message: "User added successfully", type: "success" });
                },
                onError: () => (isSubmitting.value = false),
            });
        }
    });
};
// Computed property for filtering
const filteredUsers = computed(() =>
    props.users.filter((user) =>
        [user.name, user.email, user.username].some((field) =>
            field?.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    )
);

// Pagination logic
const paginatedUsers = computed(() =>
    filteredUsers.value.slice((currentPage.value - 1) * pageSize, currentPage.value * pageSize)
);

const handlePageChange = (page) => (currentPage.value = page);

// Role-based color logic
const getRoleTag = (role) => {
    return {
        super_admin: "danger",
        manager: "warning",
        employee: "success",
        superior_hierarchique: "info",
    }[role] || "default";
};

const formatRole = (role) => {
    return role.replace("_", " ").toUpperCase();
};

// Open Modal for Add/Edit
const openModal = (user) => {
    if (user) {
        editingUserId.value = user.id;
        form.name = user.name;
        form.email = user.email;
        form.username = user.username;
        form.role = user.role;
        form.site_id = user.site_id;
        form.password = ""; // Keep password empty for security
    } else {
        editingUserId.value = null;
        form.reset();
    }
    showModal.value = true;
};

// Bulk delete handling
const handleSelection = (selection) => {
    selectedUsers.value = selection.map((u) => u.id);
};

const confirmBulkDelete = () => {
    ElMessageBox.confirm("Are you sure you want to delete selected users?", "Warning", {
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        type: "warning",
    }).then(() => {
        selectedUsers.value.forEach((id) => form.delete(route("users.destroy", id)));
        selectedUsers.value = [];
        ElMessage({ message: "Users deleted successfully", type: "success" });
    });
};

const confirmDelete = (id) => {
    ElMessageBox.confirm("Are you sure you want to delete this user?", "Warning", {
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        type: "warning",
    }).then(() => form.delete(route("users.destroy", id)));
};
</script>

<style>
.el-dialog {
    border-radius: 12px !important;
}
</style>
