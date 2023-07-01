import messages  from "../../../constants/messages.json"

const {required: requiredErrors} = messages.errors

export const fieldUpdateHandler = (fieldName, value, setValue, setValueError) => {
    if (!value) {
        setValueError(requiredErrors[fieldName])
    } else {
        setValueError("")
    }

    setValue(value)
}