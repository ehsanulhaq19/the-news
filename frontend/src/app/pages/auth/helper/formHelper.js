
export const fieldUpdateHandler = (fieldName, value, setValue, setValueError) => {
    if (!value) {
        setValueError(requiredErrors[fieldName])
    } else {
        setValueError("")
    }

    setValue(value)
}