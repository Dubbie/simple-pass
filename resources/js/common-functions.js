const getSizeClasses = (size) => {
    return {
        xs: `px-2 py-1 text-xs`,
        sm: `px-2 py-1 text-sm`,
        md: `px-3 py-2 text-sm`,
        lg: `px-3 py-2 text-sm`,
        xl: `px-3\.5 py-2\.5 text-base`,
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

export {getSizeClasses, copyToClipboard, getPasswordForEntry, getEntryById};
