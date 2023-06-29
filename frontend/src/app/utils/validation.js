
export const isValidEmail = (email) => {
    const validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email && email.match(validRegex)) {
        return true
    }
    return false
}