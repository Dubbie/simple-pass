import { usePage } from "@inertiajs/vue3";

const getSizeClasses = (size) => {
    return {
        xs: `px-2 py-1 text-xs`,
        sm: `px-2 py-1 text-sm`,
        md: `px-3 py-2 text-sm`,
        lg: `px-3 py-2 text-sm`,
        xl: `px-4 py-3 text-base`,
    }[size];
}

const copyToClipboard = (text) => {
  navigator.clipboard.writeText(text);
};

const getPasswordForEntry = async (entry) => {
    try {
        return await axios.post(
            route("password-entries.get-password", entry)
        );
    } catch (error) {
        console.log(error);
    }
};

const getEntryById = async (entryId) => {
    try {
        return await axios.post(
            route("password-entries.get-entry", entryId)
        );
    } catch (error) {
        console.log(error);
    }
};

const getFolderOptions = (folder, depth) => {
    let options = [];
    const prefix = "-".repeat(depth) + (depth > 0 ? " " : "");

    options.push({
        name: `${prefix}${folder.name}`,
        id: folder.id,
    });

    folder.sub_folders.forEach((subFolder) => {
        options = [...options, ...getFolderOptions(subFolder, depth + 1)];
    });

    return options;
};

const getAllFolderOptions = () => {
    let totalOptions = [];
    let depth = 0;
    usePage().props.folders.roots.forEach((element) => {
        totalOptions = [...totalOptions, ...getFolderOptions(element, depth)];
    });

    return totalOptions;
}

export {getSizeClasses, copyToClipboard, getPasswordForEntry, getEntryById, getFolderOptions, getAllFolderOptions};
