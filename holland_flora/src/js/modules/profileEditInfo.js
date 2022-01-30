const ACTION = "profile_action"
let body

const profileEditInfo = () => {
    if (document.querySelector(".profile-info")) {
        const form = document.querySelector(".piForm")

        const btnEdit = document.querySelectorAll(".piEdit")
        const btnSave = document.querySelectorAll(".piSave")

        btnEdit &&
        btnEdit.forEach(item => {
            item.addEventListener("click", e => {
            const currentItem = e.target.closest(".piItem")
            currentItem.classList.add("edit")
        currentItem
            .querySelector("input")
            .removeAttribute("readonly")
    })
    })

        btnSave &&
        btnSave.forEach(item => {
            item.addEventListener("click", el => {
            const currentItem = el.target.closest(".piItem")

            const input = currentItem.querySelector("input")

            const val = input.value || null
            const key = input.getAttribute("name") || null

            body = `action=${ACTION}&${key}=${val}&key=${key}`
        })
    })

        form &&
        form.addEventListener("submit", async function (e) {
            e.preventDefault()

            const method = this.getAttribute("method")
            const res = await fetch(
                this.getAttribute("action"),
                {
                    method,
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded; charset=utf-8",
                    },
                    body,
                    credentials: "same-origin",
                }
            ).then(res => {
                return res.json()
            })

            if (res) {
                if (res.success) {
                    const currentItem = document.querySelector(
                        `.piItem[data-key="${res.key}"]`
                    )

                    currentItem.classList.remove("edit")
                    currentItem
                        .querySelector("input")
                        .setAttribute("readonly", "true")
                    const input = currentItem.querySelector("input")

                    input.value = res.value
                }
                alert(res.msg)
            } else alert("Ошибка! Побробуйте снова через пару минут.'")
        })
    }
}

export default profileEditInfo
