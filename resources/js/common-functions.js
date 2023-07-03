const getSizeClasses = (size) => {
    return {
        sm: "px-2 py-1",
        md: "px-3 py-2",
        lg: "px-6 py-3",
        xl: "px-6 py-3",
        "2xl": "px-6 py-3",
    }[size];
}

export default getSizeClasses;
