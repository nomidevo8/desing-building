jQuery(document).ready(function($) {
    
    var BuildingDesigner = {
        currentStep: 'building-size',
        currentTab: 'information',
        selections: {},
        config: buildingDesignerConfig || {},

        init: function() {
            this.loadSelections();
            this.bindEvents();
            this.loadStep(this.currentStep);
        },

        bindEvents: function() {
            var self = this;
            
            $('.bd-step-btn').on('click', function() {
                var step = $(this).data('step');
                self.navigateToStep(step);
            });
            
            $('.bd-tab-btn').on('click', function() {
                var tab = $(this).data('tab');
                self.switchTab(tab);
            });
            
            $('#bd-continue-btn').on('click', function() {
                self.nextStep();
            });
            
            $('#bd-back-btn').on('click', function() {
                self.previousStep();
            });
            
            $(document).on('change', '.bd-option-select', function() {
                var optionGroup = $(this).data('option-group');
                var selectedValue = $(this).val();
                self.handleSelection(optionGroup, selectedValue);
            });
            
            $(document).on('click', '.bd-image-card', function() {
                var optionGroupId = $(this).data('option-group');
                var optionId = $(this).data('option-id');
                
                if (optionGroupId && optionId) {
                    $('.bd-image-card[data-option-group="' + optionGroupId + '"]').removeClass('selected');
                    $(this).addClass('selected');
                    
                    self.handleSelection(optionGroupId, optionId);
                    
                    var $select = $('.bd-option-select[data-option-group="' + optionGroupId + '"]');
                    $select.val(optionId);
                }
            });
            
            $(document).on('click', '.bd-option-group', function() {
                var $group = $(this);
                $('.bd-option-group').removeClass('active');
                $group.addClass('active');
                
                var optionGroup = $group.data('option-group');
                self.updateRightPanel(optionGroup);
            });
        },

        loadStep: function(stepId) {
            this.currentStep = stepId;
            this.renderOptions(stepId);
            
            $('.bd-step-btn').removeClass('active');
            $('.bd-step-btn[data-step="' + stepId + '"]').addClass('active');
        },

        renderOptions: function(stepId) {
            var self = this;
            var $container = $('#bd-options-container');
            $container.empty();
            
            if (!this.config.options || !this.config.options[stepId]) {
                $container.append('<p>No options available for this step.</p>');
                return;
            }
            
            var stepOptions = this.config.options[stepId];
            
            $.each(stepOptions, function(key, optionGroup) {
                var $group = $('<div class="bd-option-group" data-option-group="' + optionGroup.id + '"></div>');
                
                var $header = $('<div class="bd-option-header"></div>');
                $header.append('<div><p class="bd-option-header-title">' + optionGroup.label + '</p><div class="bd-option-question">' + (optionGroup.question || '') + '</div></div>');
                
                $group.append($header);
                
                if (optionGroup.type === 'select') {
                    var $select = $('<select class="bd-option-select" data-option-group="' + optionGroup.id + '"></select>');
                    $select.append('<option value="">Choose ' + optionGroup.label.toLowerCase() + '</option>');
                    
                    $.each(optionGroup.options, function(i, option) {
                        $select.append('<option value="' + option.id + '">' + option.label + '</option>');
                    });
                    
                    if (self.selections[optionGroup.id]) {
                        $select.val(self.selections[optionGroup.id]);
                    }
                    
                    $group.append($select);
                } else if (optionGroup.type === 'image-tile') {
                    var $select = $('<select class="bd-option-select" data-option-group="' + optionGroup.id + '"></select>');
                    $select.append('<option value="">Choose ' + optionGroup.label.toLowerCase() + '</option>');
                    
                    $.each(optionGroup.options, function(i, option) {
                        $select.append('<option value="' + option.id + '">' + option.label + '</option>');
                    });
                    
                    if (self.selections[optionGroup.id]) {
                        $select.val(self.selections[optionGroup.id]);
                    }
                    
                    $group.append($select);
                }
                
                $container.append($group);
            });
            
            if (Object.keys(stepOptions).length > 0) {
                var activeGroupId = null;
                
                $.each(stepOptions, function(key, optionGroup) {
                    if (self.selections[optionGroup.id]) {
                        activeGroupId = optionGroup.id;
                        return false;
                    }
                });
                
                if (!activeGroupId) {
                    activeGroupId = stepOptions[Object.keys(stepOptions)[0]].id;
                }
                
                $('.bd-option-group[data-option-group="' + activeGroupId + '"]').addClass('active');
                this.updateRightPanel(activeGroupId);
            }
        },

        handleSelection: function(optionGroupId, selectedValue) {
            this.selections[optionGroupId] = selectedValue;
            this.updateRightPanel(optionGroupId);
            this.saveSelections();
            
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('building_designer_selection_changed', this.selections);
            }
        },

        updateRightPanel: function(optionGroupId) {
            var stepOptions = this.config.options[this.currentStep];
            if (!stepOptions) return;
            
            var optionGroup = null;
            $.each(stepOptions, function(key, group) {
                if (group.id === optionGroupId) {
                    optionGroup = group;
                    return false;
                }
            });
            
            if (!optionGroup) return;
            
            $('#bd-current-title').text(optionGroup.label);
            
            var $imagesContainer = $('#bd-images-container');
            $imagesContainer.empty();
            
            var $descriptionContainer = $('#bd-description-container');
            $descriptionContainer.empty();
            
            if (optionGroup.type === 'image-tile' && optionGroup.options) {
                var selectedValue = this.selections[optionGroupId];
                
                $.each(optionGroup.options, function(i, option) {
                    var $card = $('<div class="bd-image-card" data-option-group="' + optionGroup.id + '" data-option-id="' + option.id + '"></div>');
                    $card.css('cursor', 'pointer');
                    
                    if (selectedValue && option.id === selectedValue) {
                        $card.addClass('selected');
                    }
                    
                    if (option.image_url) {
                        $card.append('<img src="' + option.image_url + '" alt="' + option.label + '">');
                    }
                    
                    $card.append('<div class="bd-image-card-title">' + option.label + '</div>');
                    
                    $imagesContainer.append($card);
                    
                    if (option.description) {
                        $descriptionContainer.append('<div>' + option.description + '</div>');
                    }
                });
            } else if (optionGroup.type === 'select' && optionGroup.options) {
                var selectedValue = this.selections[optionGroupId];
                
                if (selectedValue) {
                    var selectedOption = null;
                    $.each(optionGroup.options, function(i, option) {
                        if (option.id === selectedValue) {
                            selectedOption = option;
                            return false;
                        }
                    });
                    
                    if (selectedOption) {
                        if (selectedOption.image_url) {
                            var $card = $('<div class="bd-image-card"></div>');
                            $card.append('<img src="' + selectedOption.image_url + '" alt="' + selectedOption.label + '">');
                            $card.append('<div class="bd-image-card-title">' + selectedOption.label + '</div>');
                            $imagesContainer.append($card);
                        }
                        
                        if (selectedOption.description) {
                            $descriptionContainer.append('<div>' + selectedOption.description + '</div>');
                        }
                    }
                } else {
                    $.each(optionGroup.options, function(i, option) {
                        var $card = $('<div class="bd-image-card"></div>');
                        
                        if (option.image_url) {
                            $card.append('<img src="' + option.image_url + '" alt="' + option.label + '">');
                        }
                        
                        $card.append('<div class="bd-image-card-title">' + option.label + '</div>');
                        
                        $imagesContainer.append($card);
                    });
                }
            }
        },

        switchTab: function(tab) {
            this.currentTab = tab;
            $('.bd-tab-btn').removeClass('active');
            $('.bd-tab-btn[data-tab="' + tab + '"]').addClass('active');
        },

        navigateToStep: function(stepId) {
            this.loadStep(stepId);
        },

        nextStep: function() {
            var steps = this.getStepOrder();
            var currentIndex = steps.indexOf(this.currentStep);
            
            if (currentIndex < steps.length - 1) {
                this.navigateToStep(steps[currentIndex + 1]);
            }
        },

        previousStep: function() {
            var steps = this.getStepOrder();
            var currentIndex = steps.indexOf(this.currentStep);
            
            if (currentIndex > 0) {
                this.navigateToStep(steps[currentIndex - 1]);
            }
        },

        getStepOrder: function() {
            if (!this.config.steps) return [];
            
            return this.config.steps.sort(function(a, b) {
                return a.order - b.order;
            }).map(function(step) {
                return step.id;
            });
        },

        saveSelections: function() {
            var self = this;
            localStorage.setItem('building_designer_selections', JSON.stringify(this.selections));
            
            if (this.config.ajaxUrl && this.config.nonce) {
                clearTimeout(this.saveTimeout);
                this.saveTimeout = setTimeout(function() {
                    $.ajax({
                        url: self.config.ajaxUrl,
                        type: 'POST',
                        data: {
                            action: 'building_designer_save_selection',
                            nonce: self.config.nonce,
                            selections: JSON.stringify(self.selections)
                        },
                        success: function(response) {
                            console.log('Selections saved to server');
                        },
                        error: function(xhr, status, error) {
                            console.warn('Failed to save selections to server:', error);
                        }
                    });
                }, 500);
            }
        },

        loadSelections: function() {
            var saved = localStorage.getItem('building_designer_selections');
            if (saved) {
                this.selections = JSON.parse(saved);
            }
        }
    };
    
    BuildingDesigner.init();
});
