// Multi-step form functionality
document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step');
    const formSteps = document.querySelectorAll('[id^="step-"]');
    const progressBar = document.getElementById('progress-bar');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const form = document.getElementById('colis-form');
    let currentStep = 1;
    
    // Calculate costs
    function calculateCosts() {
        const serviceType = document.querySelector('input[name="service_type"]:checked')?.value || 'standard';
        const declaredValue = parseFloat(document.getElementById('declared_value').value) || 0;
        const insuranceChecked = document.getElementById('insurance').checked;
        const fragileChecked = document.getElementById('fragile').checked;
        
        let baseCost = serviceType === 'express' ? 400000 : 250000;
        let insuranceCost = insuranceChecked ? declaredValue * 0.02 : 0;
        let fragileCost = fragileChecked ? 50000 : 0;
        let handlingCost = 25000;
        
        if (document.getElementById('insurance-cost')) {
            document.getElementById('insurance-cost').textContent = insuranceCost.toLocaleString('fr-FR') + ' GNF';
        }
        
        const totalCost = baseCost + insuranceCost + fragileCost + handlingCost;
        if (document.getElementById('total-cost')) {
            document.getElementById('total-cost').textContent = totalCost.toLocaleString('fr-FR') + ' GNF';
        }
    }
    
    // Next button click handler
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                updateForm();
                
                // Update tracking number preview
                if (currentStep === 3) {
                    const trackingNumber = 'AD' + Math.random().toString(36).substr(2, 9).toUpperCase();
                    if (document.getElementById('tracking-number-preview')) {
                        document.getElementById('tracking-number-preview').textContent = trackingNumber;
                    }
                    if (document.getElementById('final-tracking-number')) {
                        document.getElementById('final-tracking-number').textContent = trackingNumber;
                    }
                }
                
                // Calculate costs when reaching payment step
                if (currentStep === 3) {
                    calculateCosts();
                }
            }
        });
    });
    
    // Previous button click handler
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentStep--;
            updateForm();
        });
    });
    
    // Form submission handler
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...';
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                currentStep++;
                updateForm();
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }, 1500);
        });
    }
    
    // Validate current step before proceeding
    function validateStep(step) {
        let isValid = true;
        
        // Validate step 1
        if (step === 1) {
            const requiredFields = [
                'sender_name', 'sender_address', 'sender_city', 'sender_phone',
                'recipient_name', 'recipient_address', 'recipient_city', 'recipient_phone'
            ];
            
            requiredFields.forEach(field => {
                const element = document.querySelector(`[name="${field}"]`);
                if (element && !element.value.trim()) {
                    element.classList.add('border-red-500');
                    isValid = false;
                } else if (element) {
                    element.classList.remove('border-red-500');
                }
            });
        }
        
        // Validate step 2
        if (step === 2) {
            const requiredFields = ['package_type', 'weight', 'description', 'pickup_date'];
            
            requiredFields.forEach(field => {
                const element = document.querySelector(`[name="${field}"]`);
                if (element && !element.value.trim()) {
                    element.classList.add('border-red-500');
                    isValid = false;
                } else if (element) {
                    element.classList.remove('border-red-500');
                }
            });
        }
        
        if (!isValid) {
            alert('Veuillez remplir tous les champs obligatoires marqués d\'un astérisque (*)');
        }
        
        return isValid;
    }
    
    // Update form display based on current step
    function updateForm() {
        // Hide all steps
        formSteps.forEach(step => {
            step.classList.add('hidden');
        });
        
        // Show current step
        const currentStepElement = document.getElementById(`step-${currentStep}`);
        if (currentStepElement) {
            currentStepElement.classList.remove('hidden');
        }
        
        // Show confirmation step if form is completed
        if (currentStep > 3) {
            const step4 = document.getElementById('step-4');
            if (step4) {
                step4.classList.remove('hidden');
            }
        }
        
        // Update progress bar
        if (progressBar) {
            progressBar.style.width = `${((currentStep - 1) / 3) * 100}%`;
        }
        
        // Update step indicators
        steps.forEach((step, index) => {
            if (index < currentStep) {
                step.classList.add('active');
                const stepDiv = step.querySelector('div');
                const stepSpan = step.querySelector('span');
                
                if (stepDiv) {
                    stepDiv.classList.remove('bg-gray-200', 'text-gray-600');
                    stepDiv.classList.add('bg-blue-600', 'text-white');
                }
                if (stepSpan) {
                    stepSpan.classList.remove('text-gray-600');
                    stepSpan.classList.add('text-blue-600');
                }
            } else {
                step.classList.remove('active');
                const stepDiv = step.querySelector('div');
                const stepSpan = step.querySelector('span');
                
                if (stepDiv) {
                    stepDiv.classList.add('bg-gray-200', 'text-gray-600');
                    stepDiv.classList.remove('bg-blue-600', 'text-white');
                }
                if (stepSpan) {
                    stepSpan.classList.add('text-gray-600');
                    stepSpan.classList.remove('text-blue-600');
                }
            }
        });
    }
    
    // Event listeners for cost calculation
    const insuranceCheckbox = document.getElementById('insurance');
    const fragileCheckbox = document.getElementById('fragile');
    const declaredValueInput = document.getElementById('declared_value');
    
    if (insuranceCheckbox) {
        insuranceCheckbox.addEventListener('change', calculateCosts);
    }
    if (fragileCheckbox) {
        fragileCheckbox.addEventListener('change', calculateCosts);
    }
    if (declaredValueInput) {
        declaredValueInput.addEventListener('input', calculateCosts);
    }
    
    const serviceTypeRadios = document.querySelectorAll('input[name="service_type"]');
    serviceTypeRadios.forEach(radio => {
        radio.addEventListener('change', calculateCosts);
    });
});